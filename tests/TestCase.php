<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login($user = null)
    {
        $user = $user ?? factory(\App\User::class)->create();
        $this->actingAs($user, 'web');
        return $user;
    }
    protected function loginAsAdmin($user = null)
    {
        $user = $user ?? factory(\App\User::class)->create();
        $user->is_admin = true;
        $user->save();
        $this->actingAs($user, 'web');
        return $user;
    }
    protected function arrayAsString($array)
    {
        return '["' . implode('","', $array) . '"]';
    }
}
