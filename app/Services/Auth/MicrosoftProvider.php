<?php

namespace App\Services\Auth;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class MicrosoftProvider extends AbstractProvider implements ProviderInterface
{
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://login.windows.net/common/oauth2/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return 'https://login.windows.net/common/oauth2/token';
    }

    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' =>
            [
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params'    => $this->getTokenFields($code),
        ]);

        return $this->parseAccessToken($response->getBody());
    }

    protected function getTokenFields($code)
    {
        $base_args = parent::getTokenFields($code);
        $base_args = array_add($base_args, 'resource', 'https://graph.windows.net');
        $base_args = array_add($base_args, 'grant_type', 'authorization_code');

        return $base_args;
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.windows.net/me?api-version=1.5', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'email'         => $user['mail'],
            'nickname'      => $user['mailNickname'],
            'name'          => $user['displayName'],
            'firstName'     => $user['givenName'],
            'lastName'      => $user['surname'],
            'externalId'    => $user['objectId'],
        ]);
    }
}
