<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function updated(User $user): void
    {
        if($user->isDirty('filament_user') && !$user->filament_user)
        {
            $user->roles()->detach();

            if(Auth::user()->id === $user->id)
            {
                Auth::logout();
            }
        }
    }

    public function deleted(user $user): void
    {
        if(Auth::user()->id === $user->id)
        {
            Auth::logout();
        }
    }
}
