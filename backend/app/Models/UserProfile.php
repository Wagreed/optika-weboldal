<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'insurance_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_notes',
        'preferred_language',
        'newsletter_subscription',
    ];

    protected function casts(): array
    {
        return [
            'newsletter_subscription' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
