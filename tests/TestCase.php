<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login($user = null)
    {
        $this->actingAs($user ?? factory(\App\User::class)->create());
    }
    protected function loginAdmin($user = null)
    {
        $user = $user ?? factory(\App\User::class)->create();
        $user->is_admin = true;
        $user->save();
        $this->actingAs($user);
    }
    protected function arrayAsString($array)
    {
        return '["' . implode('","', $array) . '"]';
    }
}
