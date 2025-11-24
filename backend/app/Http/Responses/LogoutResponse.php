<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Delete all Sanctum tokens for the user
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Redirect to frontend home page
        return redirect(config('app.frontend_url', 'http://localhost:3000'));
    }
}