<?php

/**
 * Register new user.
 *
 * @param  array $user
 * @return void
 */
function register($user)
{
    $email = App\Models\User::where('email', $user['email'])->get();

    if ($email->count() > 0) {
        return redirect('/register', ['error' => 'Correo electrónico ya se encuentra registrado']);
    }

    if ($user['password'] != $user['confirm_password']) {
        return redirect('/register', ['error' => 'Las contraseñas no coinciden']);
    }

    $user = App\Models\User::create([
        'name'     => $user['name'],
        'email'    => $user['email'],
        'password' => md5($user['password']),
    ]);

    $user->update(['hash' => md5($user->id)]);

    return redirect('/login', ['info' => 'Usuario registrado, ahora puedes iniciar sesión']);
}

/**
 * Login a session.
 *
 * @param array $user
 * @return void
 */
function login($user)
{
    $user = App\Models\User::where('email', $user['email'])
        ->where('password', md5($user['password']))
        ->whereNull('oauth')
        ->first();

    if ($user) {
        $_SESSION['id'] = $user->id;
        $_SESSION['name'] = $user->name;
        $_SESSION['email'] = $user->email;
        $_SESSION['role'] = $user->role;
        $_SESSION['permissions'] = $user->permissions;
        $_SESSION['photo'] = $user->photo;

        return redirect('/dashboard');
    } else {
        return redirect('/login', ['error' => 'Datos incorrectos']);
    }
}

/**
 * Get a session var.
 *
 * @param  mixed  $var
 * @param  array\boolean\string
 */
function auth() {
    if (isset($_SESSION['id'])) {
        $user = App\Models\User::find($_SESSION['id']);
        return $user;
    }

    return false;
}

/**
 * Send email for reset password.
 *
 * @return void
 */
function forgot()
{
    if (post()) {
        $user = App\Models\User::where('email', post('email'))->first();

        if (!$user) {
            return redirect('/forgot-password', ['error' => 'No podemos encontrar un usuario con esa dirección de correo electrónico']);
        }

        email()->from('admin@' . $_SERVER['HTTP_HOST'])
            ->to($user->email)
            ->subject('Recuperación de contraseña de ' . config('application_name'))
            ->view('recover')
            ->data(compact('user'))
            ->send();

        return redirect('/forgot-password', ['info' => 'Revise su correo electrónico para recuperar su contraseña']);
    }
}

/**
 * Recover password.
 *
 * @return void
 */
function recover()
{
    if (post()) {
        $user = App\Models\User::where('hash', post('id'))->first();

        if (!$user) {
            return redirect('/login', ['error' => 'Enlace de recuperación de contraseña inválido']);
        }

        if (post('password') != post('confirm_password')) {
            return redirect('/recover/' . post('id'), ['error' => 'Las contraseñas no coinciden']);
        }

        $user->password = md5(post('password'));
        $user->save();

        return redirect('/login', ['error' => 'Contraseña cambiada exitosamente, ahora puedes iniciar sesión']);
    }

}

/**
 * Logout session.
 *
 * @return void
 */
function logout()
{
    session_destroy();
}
