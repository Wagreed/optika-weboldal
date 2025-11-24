<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birth_date',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's appointments as a customer.
     */
    public function customerAppointments()
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

    /**
     * Get the user's appointments as staff.
     */
    public function staffAppointments()
    {
        return $this->hasMany(Appointment::class, 'staff_id');
    }

    /**
     * Get the user's staff schedules.
     */
    public function staffSchedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }

    /**
     * Get the user's eye examinations as a customer.
     */
    public function eyeExaminations()
    {
        return $this->hasMany(EyeExamination::class, 'customer_id');
    }

    /**
     * Get the user's orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
