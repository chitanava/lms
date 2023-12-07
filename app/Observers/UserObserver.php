<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function updating(User $user): void
    {
        if(!$user->filament_user) {
            $user->roles()->detach();
        }
    }
}
