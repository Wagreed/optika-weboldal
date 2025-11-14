<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EyeExamination extends Model
{
    protected $fillable = [
        'appointment_id',
        'customer_id',
        'examiner_id',
        'examination_date',
        'visual_acuity_right_eye',
        'visual_acuity_left_eye',
        'sphere_right',
        'cylinder_right',
        'axis_right',
        'sphere_left',
        'cylinder_left',
        'axis_left',
        'pupillary_distance',
        'intraocular_pressure_right',
        'intraocular_pressure_left',
        'color_vision_test_result',
        'examination_notes',
        'recommendations',
        'next_examination_recommended',
    ];

    protected function casts(): array
    {
        return [
            'examination_date' => 'date',
            'sphere_right' => 'decimal:2',
            'cylinder_right' => 'decimal:2',
            'sphere_left' => 'decimal:2',
            'cylinder_left' => 'decimal:2',
            'pupillary_distance' => 'decimal:1',
            'next_examination_recommended' => 'date',
        ];
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'examination_id');
    }
}
