<?php

namespace App\Controllers;

use App\Models\User;
use App\Validations\UserStoreValidation;
use App\Validations\UserUpdateValidation;
use Redirect;
use View;

class UserController extends Controller
{
    /**
     * Verify if user is logged.
     */
    public function __construct()
    {
        $this->middleware('Auth');
    }

    /**
     * Show home page.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::get();

        return view('users.index', compact('users'));
    }

    /**
     * Show create user page.
     *
     * @return View
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store user in database.
     *
     * @param  UserStoreValidation  $validation
     * @return Redirect
     */
    public function store(UserStoreValidation $validation): Redirect
    {
        $file = request('photo')->save('resources/assets/img');

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => encrypt(request('password')),
            'photo' => $file->filename,
        ]);

        $user->update(['hash' => encrypt($user->id)]);

        return redirect('/dashboard/users')->with('info', lang('users.store'));
    }

    /**
     * Show edit user page.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update user in database.
     *
     * @param  UserUpdateValidation  $validation
     * @return Redirect
     */
    public function update(UserUpdateValidation $validation): Redirect
    {
        $user = User::find(request('id'));
        $user->update([
            'name' => request('name'),
            'email' => request('email'),
        ]);

        if (request('password')) {
            $user->update([
                'password' => encrypt(request('password')),
            ]);
        }

        if (request('photo')) {
            $file = request('photo')->save('resources/assets/img');
            
            $user->update([
                'photo' => $file->filename,
            ]);
        }

        if (request('2fa')) {
            if ($user->two_fa) {
                $user->two_fa = null;
            } else {
                $user->two_fa = two_fa()->key();
            }

            $user->save();
        }

        if ($user->id == session('id')) {
            session('name', $user->name);
            session('photo', $user->photo);
        }

        return redirect('/dashboard/users')->with('info', lang('users.update'));
    }

    /**
     * Delete user in database.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function delete(int $id): Redirect
    {
        if ($id == session('id')) {
            return redirect('/dashboard/users')->with('error', lang('users.in_use'));
        }

        User::find($id)->delete();

        return redirect('/dashboard/users')->with('info', lang('users.delete'));
    }

    /**
     * Logout in others devices.
     * 
     * @param int $id
     * @return void
     */
    public function logoutInOthersDevices(int $id): void
    {
        $user = User::find($id);
        $user->update(['sessions' => '[]']);

        return redirect('/dashboard/users/edit/' . $id);
    }
}
