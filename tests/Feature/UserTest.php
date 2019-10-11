<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    function it_can_be_made_admin_by_admin()
    {
        $this->loginAsAdmin();
        $user = factory(User::class)->create();

        $this->patch(route('users.update', $user), ['is_admin' => true])
            ->assertSessionHasNoErrors();
    }

    /** @test */
    function it_cannot_be_made_admin_by_non_system_admin()
    {
        factory(User::class)->create();
        $user = $this->login();

        $this->patch(route('users.update', $user), ['is_admin' => true])
            ->assertSessionHasErrors('is_admin');
    }

    /** @test */
    function it_validates_password()
    {
        $user = $this->login();

        session()->put('test');
        $this // Check uppercase
            ->patch(route('users.update', $user), ['password' => 'password1%', 'password_confirmation' => 'password1%'])
            ->assertSessionHasErrors('password');

        $this // Check lowercase
            ->patch(route('users.update', $user), ['password' => 'PASSWORD1%', 'password_confirmation' => 'PASSWORD1%'])
            ->assertSessionHasErrors('password');

        $this // Check number
            ->patch(route('users.update', $user), ['password' => 'Password%', 'password_confirmation' => 'Password%'])
            ->assertSessionHasErrors('password');

        $this // Check symbol
            ->patch(route('users.update', $user), ['password' => 'Password1', 'password_confirmation' => 'Password1'])
            ->assertSessionHasErrors('password');

        $this // Check length
            ->patch(route('users.update', $user), ['password' => 'Pa1%', 'password_confirmation' => 'Pa1%'])
            ->assertSessionHasErrors('password');

        $this // Check length
            ->patch(route('users.update', $user), ['password' => 'PasswOrd1%', 'password_confirmation' => 'PasswOrd1%'])
            ->assertSessionHasNoErrors();
    }

    /** @test */
    function it_gets_success_flashed()
    {
        $user = $this->login();
        $this->patch(route('users.update', $user), ['password' => 'PasswOrd1%', 'password_confirmation' => 'PasswOrd1%'])
            ->assertSessionHas('message', $user->name.'\'s password was updated.');
    }
}
