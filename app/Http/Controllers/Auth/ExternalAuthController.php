<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Socialite;

class ExternalAuthController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the Provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(string $provider)
    {
        $pUser = Socialite::driver($provider)->user();
        $user = $this->firstOrNewUser($pUser);
        auth()->login($user);
        return redirect('/dashboard');
    }

    /**
     * Create a new system user from the provider's user.
     *
     * @param mixed $pUser The provider's user to convert.
     * @return \App\User
     */
    protected function firstOrNewUser($pUser) : User
    {
        $user = User::firstOrNew([
            'email' => $pUser->getEmail()
        ]);

        if ($user->exists()) {
            return $user;
        }
        
        $user->fill([
            'name' => $pUser->getName() ?? $pUser->name,
            'password' => Str::random(16),
            'email_verified_at' => Carbon::now()
        ]);
        $user->save();
        $user->auth_config->update(['config' => [
            'avatar' => $pUser->getAvatar(),
            'token' => $pUser->token ?? null,
            'id' => $pUser->getId()
        ]]);
        return $user;
    }
}
