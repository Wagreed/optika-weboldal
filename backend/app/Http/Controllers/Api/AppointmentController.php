<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RomanianHolidays;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Az összes lehetséges időpont slot – a frontend ugyanezt használja
    private const TIME_SLOTS = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];

    public function types()
    {
        $types = AppointmentType::where('is_active', true)
            ->get(['id', 'name', 'description', 'duration_minutes', 'price', 'color']);

        return response()->json(['types' => $types]);
    }

    public function availability(Request $request)
    {
        $year  = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        $from = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $to   = $from->clone()->endOfMonth();

        // 1. Admin által zárolt napok
        $customBlocked = BlockedDate::whereBetween('date', [$from, $to])
            ->get()
            ->mapWithKeys(fn ($b) => [
                $b->date->format('Y-m-d') => $b->reason ?? 'Zárva',
            ])
            ->all();

        // 2. Román munkaszüneti napok az adott hónapra szűrve
        $allHolidays = RomanianHolidays::forYear($year);
        // Ha az év határán vagyunk, a következő év januárját is nézzük
        if ($month === 12) {
            $allHolidays = array_merge($allHolidays, RomanianHolidays::forYear($year + 1));
        }
        $monthHolidays = array_filter(
            $allHolidays,
            fn ($date) => str_starts_with($date, "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT)),
            ARRAY_FILTER_USE_KEY
        );

        // Összes blokkolt nap (custom + ünnep), formátum: date => reason
        $blockedDates = array_merge($monthHolidays, $customBlocked);

        // 3. Foglalt időpontok az adott hónapban (pending + confirmed)
        $appointments = Appointment::whereBetween('appointment_date', [$from, $to])
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereNotNull('start_time')
            ->get(['appointment_date', 'start_time']);

        // Csoportosítás dátum szerint: date => [slot1, slot2, ...]
        $bookedSlots = [];
        foreach ($appointments as $appt) {
            $date = $appt->appointment_date->format('Y-m-d');
            $slot = substr($appt->start_time, 0, 5);
            $bookedSlots[$date][] = $slot;
        }

        // Teljesen foglalt napok: ahol minden slot le van foglalva
        $fullyBookedDates = [];
        foreach ($bookedSlots as $date => $slots) {
            if (count(array_unique($slots)) >= count(self::TIME_SLOTS)) {
                $fullyBookedDates[] = $date;
            }
        }

        return response()->json([
            'blocked_dates'     => $blockedDates,
            'booked_slots'      => $bookedSlots,
            'fully_booked_dates' => $fullyBookedDates,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth('sanctum')->user();

        $validated = $request->validate([
            'appointment_date'    => 'required|date|after_or_equal:today',
            'start_time'          => 'required|string|max:10',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'guest_name'          => $user ? 'nullable' : 'required|string|max:255',
            'guest_email'         => $user ? 'nullable' : 'required|email|max:255',
            'customer_notes'      => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create([
            'customer_id'         => $user?->id,
            'guest_name'          => $user ? null : $validated['guest_name'],
            'guest_email'         => $user ? null : $validated['guest_email'],
            'appointment_type_id' => $validated['appointment_type_id'],
            'appointment_date'    => $validated['appointment_date'],
            'start_time'          => $validated['start_time'],
            'status'              => 'pending',
            'customer_notes'      => $validated['customer_notes'] ?? null,
        ]);

        return response()->json([
            'message'     => 'Időpont kérés sikeresen elküldve',
            'appointment' => $appointment->load('appointmentType'),
        ], 201);
    }

    public function myAppointments(Request $request)
    {
        $appointments = Appointment::with('appointmentType')
            ->where('customer_id', $request->user()->id)
            ->orderBy('appointment_date', 'desc')
            ->get(['id', 'appointment_date', 'start_time', 'status', 'appointment_type_id', 'customer_notes', 'created_at']);

        return response()->json(['appointments' => $appointments]);
    }
}
