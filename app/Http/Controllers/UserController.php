<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('manage', App\User::class);
        return $this->view('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('manage', App\User::class);
        return $this->view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.config', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'password' => [
                'string', 'confirmed', 'min:8', 'max:128',
                'contain_number', 'contain_upper_case', 'contain_lower_case',
                'contain_symbol'
            ],
            'is_admin' => [ 'can:manage,App\User', 'boolean' ]
        ]);
        $user->update($validated);
        if (isset($validated['password'])) {
            session()->flash('message', __('users.updated.password', ['user' => $user->name]));
        } elseif (isset($validated['is_admin'])) {
            session()->flash('message', __('users.updated.is_admin', ['user' => $user->name]));
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
