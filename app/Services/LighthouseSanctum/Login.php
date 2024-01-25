<?php

namespace App\Services\LighthouseSanctum;

use DanielDeWit\LighthouseSanctum\Exceptions\HasApiTokensException;
use DanielDeWit\LighthouseSanctum\GraphQL\Mutations\Login as DanielDeWitLogin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class Login extends DanielDeWitLogin
{
    public function __invoke(mixed $_, array $args): array
    {
        $userProvider = $this->createUserProvider();

        $identificationKey = $this->getConfig()
            ->get('lighthouse-sanctum.user_identifier_field_name', 'email');

        $user = $userProvider->retrieveByCredentials([
            $identificationKey => $args[$identificationKey],
            'password'         => $args['password'],
        ]);

        if (! $user || ! $userProvider->validateCredentials($user, $args)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return [
                'token'  => null,
                'status' => 'MUST_VERIFY_EMAIL',
            ];
        }

        if (! $user instanceof HasApiTokens) {
            throw new HasApiTokensException($user);
        }

        return [
            'token' => $user->createToken('default')->plainTextToken,
            'status' => 'SUCCESS',
        ];
    }
}
