<?php

use App\Models\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook as FacebookSDK;

class Facebook
{
    public $helper;

    public $permissions;

    public $instance;

    public function __construct()
    {
        if (! class_exists('Facebook\Facebook')) {
            throw new Exception("Please execute 'composer require facebook/graph-sdk' in console.");
        }
    }

    public static function init()
    {
        $class = new static;

        $facebook = new FacebookSDK([
            'app_id' => config('facebook')->app_id,
            'app_secret' => config('facebook')->app_secret,
            'default_graph_version' => 'v2.10',
        ]);

        $class->instance = $facebook;

        $class->helper = $facebook->getRedirectLoginHelper();

        $class->permissions = ['email'];

        return $class;
    }

    public function login()
    {
        try {
            $accessToken = $this->helper->getAccessToken();
            $response = $this->instance->get('/me?fields=name,first_name,last_name,email,link,gender,picture', $accessToken);
        } catch (FacebookResponseException $exception) {
            echo 'Graph returned an error: ' . $exception->getMessage();

            return $this;
            exit;
        } catch (FacebookSDKException $exception) {
            echo 'Facebook SDK returned an error: ' . $exception->getMessage();

            return $this;
            exit;
        }

        $me = $response->getGraphUser();

        $user = User::firstOrCreate(
            [
                'email' => $me->getEmail(),
                'oauth' => 'Facebook',
            ],
            ['name' => $me->getName()]
        );

        session('id', $user->id);

        redirect(config('facebook')->redirect);

        return $this;
    }

    public function url()
    {
        $callback = 'http://' . $_SERVER['HTTP_HOST'] . '/login?facebook=1';
        echo $this->helper->getLoginUrl($callback, $this->permissions);
    }
}
