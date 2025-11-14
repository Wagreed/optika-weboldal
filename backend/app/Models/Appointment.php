<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id',
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
            'reminder_sent' => 'boolean',
            'price' => 'decimal:2',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * Get the customer.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the staff member.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get the appointment type.
     */
    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class);
    }

    /**
     * Get the eye examination.
     */
    public function eyeExamination()
    {
        return $this->hasOne(EyeExamination::class);
    }
}
