<?php

/**
 * Authentication with Facebook, require facebook/graph-sdk.
 */
class Facebook
{
    /**
     * Helper of the Facebook SDK.
     *
     * $helper object
     */
    public $helper;

    /**
     * Permissions of the Facebook app.
     *
     * $permissions array
     */
    public $permissions;

    /**
     * Instance of the Facebook\Facebook class.
     *
     * $instance object
     */
    public $instance;

    /**
     * Initialize the class to use from a global function.
     *
     * @return Facebook
     */
    public static function init()
    {
        $class = new static;

        $facebook = new Facebook\Facebook([
            'app_id'                => config('facebook', 'app_id'),
            'app_secret'            => config('facebook', 'app_secret'),
            'default_graph_version' => 'v2.10',
        ]);

        $class->instance = $facebook;

        $class->helper = $facebook->getRedirectLoginHelper();

        $class->permissions = ['email'];

        return $class;
    }

    /**
     * Create URL to log in to Facebook.
     *
     * @param $callback string
     * @return string
     */
    public function url($callback)
    {
        echo $this->helper->getLoginUrl($callback, $this->permissions);
    }

    /**
     * Login with Facebook account.
     *
     * @return redirect
     */
    public function login()
    {
        try {
            $accessToken = $this->helper->getAccessToken();

            $response = $this->instance->get('/me?fields=name,first_name,last_name,email,link,gender,picture', $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $exception) {
            echo 'Graph returned an error: ' . $exception->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $exception) {
            echo 'Facebook SDK returned an error: ' . $exception->getMessage();
            exit;
        }

        $me = $response->getGraphUser();

        $user = App\Models\User::firstOrCreate(
            [
                'email' => $me->getEmail(),
                'oauth' => 'Facebook',
            ],
            ['name' => $me->getName()]
        );

        $_SESSION['id']          = $user->id;
        $_SESSION['name']        = $user->name;
        $_SESSION['email']       = $user->email;
        $_SESSION['role']        = $user->role;
        $_SESSION['permissions'] = $user->permissions;

        return redirect('/');
    }
}
