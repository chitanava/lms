<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final readonly class Login
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $guard = Auth::guard(Arr::first(config('sanctum.guard')));

        if( ! $guard->attempt($args)) {
            throw new Error('Invalid credentials.');
        }

        $user = $guard->user();
        assert($user instanceof User, 'Since we successfully logged in, this can no longer be `null`.');

        return $user;
    }
}
