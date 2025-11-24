<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    /**
     * Get user profile
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('profile');

        return response()->json([
            'user' => $user,
            'profile' => $user->profile
        ]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'insurance_number' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string',
            'preferred_language' => 'nullable|in:hu,en,ro',
            'newsletter_subscription' => 'nullable|boolean',
        ]);

        $user = $request->user();

        // Update user fields
        $userFields = ['name', 'phone', 'birth_date', 'address'];
        foreach ($userFields as $field) {
            if (isset($validated[$field])) {
                $user->$field = $validated[$field];
            }
        }
        $user->save();

        // Update profile fields
        $profileFields = [
            'insurance_number',
            'emergency_contact_name',
            'emergency_contact_phone',
            'medical_notes',
            'preferred_language',
            'newsletter_subscription'
        ];

        $profileData = [];
        foreach ($profileFields as $field) {
            if (isset($validated[$field])) {
                $profileData[$field] = $validated[$field];
            }
        }

        if (!empty($profileData)) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
        }

        return response()->json([
            'user' => $user->fresh()->load('profile'),
            'message' => 'Profil sikeresen frissítve!'
        ]);
    }

    /**
     * Upload user avatar
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048', // Max 2MB
        ]);

        $user = $request->user();

        // Delete old avatar if exists
        if ($user->profile && $user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        // Store new avatar
        $file = $request->file('avatar');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('avatars', $filename, 'public');

        // Update profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['avatar' => $path]
        );

        return response()->json([
            'avatar_url' => Storage::url($path),
            'message' => 'Profilkép sikeresen feltöltve!'
        ]);
    }
}