<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;


class CustomUserProvider extends UserProvider {

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $emailMatches = strcmp($user->email, $credentials['email']) == 0;
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword()) && $emailMatches;
    }

}
