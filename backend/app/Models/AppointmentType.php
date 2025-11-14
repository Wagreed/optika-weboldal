<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'price',
        'color',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the appointments for this type.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
