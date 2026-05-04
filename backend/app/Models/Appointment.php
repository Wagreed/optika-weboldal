<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id',
        'guest_name',
        'guest_email',
        'staff_id',
        'appointment_type_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'customer_notes',
        'internal_notes',
        'reminder_sent',
        'confirmation_token',
        'price',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'reminder_sent'    => 'boolean',
            'price'            => 'decimal:2',
            'cancelled_at'     => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function eyeExamination()
    {
        return $this->hasOne(EyeExamination::class);
    }

    // Az email a regisztrált ügyféltől vagy a vendég adatából
    public function getContactEmail(): ?string
    {
        return $this->customer?->email ?? $this->guest_email;
    }

    // A név a regisztrált ügyféltől vagy a vendég adatából
    public function getContactName(): string
    {
        return $this->customer?->name ?? $this->guest_name ?? 'Ismeretlen';
    }
}
