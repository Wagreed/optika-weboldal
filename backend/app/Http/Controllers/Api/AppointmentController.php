<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function types()
    {
        $types = AppointmentType::where('is_active', true)
            ->get(['id', 'name', 'description', 'duration_minutes', 'price', 'color']);

        return response()->json(['types' => $types]);
    }

    public function store(Request $request)
    {
        // auth('sanctum')->user() működik tokenes kéréseken middleware nélkül is
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
