<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'examination_id',
        'quantity',
        'unit_price',
        'total_price',
        'prescription_right_sphere',
        'prescription_right_cylinder',
        'prescription_right_axis',
        'prescription_left_sphere',
        'prescription_left_cylinder',
        'prescription_left_axis',
        'pupillary_distance',
        'lens_type',
        'lens_coating',
        'special_instructions',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'prescription_right_sphere' => 'decimal:2',
            'prescription_right_cylinder' => 'decimal:2',
            'prescription_left_sphere' => 'decimal:2',
            'prescription_left_cylinder' => 'decimal:2',
            'pupillary_distance' => 'decimal:1',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function examination()
    {
        return $this->belongsTo(EyeExamination::class);
    }
}
