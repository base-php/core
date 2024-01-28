<?php

namespace App\Controllers;

use App\Models\User;
use App\Validations\UserStoreValidation;
use App\Validations\UserUpdateValidation;

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
     * Show all users.
     *
     * @return Response
     */
    public function index(): Response
    {
        $users = User::get();
        return response()->json(['users' => $users]);
    }

    /**
     * Store user in database.
     *
     * @param  UserStoreValidation  $validation
     * @return Response
     */
    public function store(UserStoreValidation $validation): Response
    {
        $file = request('photo')->save('resources/assets/img');

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => encrypt(request('password')),
            'photo' => $file->filename,
        ]);

        $user->update(['hash' => encrypt($user->id)]);

        $response = [
            'info' => lang('Successfully registered user.'),
            'user' => $user
        ];

        return response()->json($response);
    }

    /**
     * Update user in database.
     *
     * @param  UserUpdateValidation  $validation
     * @return Response
     */
    public function update(UserUpdateValidation $validation): Response
    {
        $user = User::find(request('id'));

        if (! $user) {
            return abort(404);
        }

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

        $response = [
            'info' => lang('User successfully updated.'),
            'user' => $user
        ];

        return response()->json($response);
    }

    /**
     * Delete user in database.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        if ($id == session('id')) {
            return redirect('/dashboard/users')->with('error', lang('Cannot be deleted, user is in use.'));
        }

        $user = User::find($id);

        if (! $user) {
            return abort(404);
        }

        $user->delete();

        return response()->json(['info' => lang('Delete user')]);
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
        
        if (! $user) {
            return abort(404);
        }

        $user->update(['sessions' => '[]']);
    }
}
