<?php

function ajax()
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        return true;
    }

    return false;
}

function error($data)
{
    echo $data;
}

function errors()
{
    if (session('basephp-flash.errors')) {
        return session('basephp-flash.errors');
    }
}

function get($var = '')
{
    if ($var == '') {
        return $_GET;
    } else {
        if (isset($_GET[$var]) && $_GET[$var] != '') {
            return $_GET[$var];
        }
    }
}

function headers($header)
{
    return getallheaders()[$header] ?? null;
}

function host()
{
    return '//'.$_SERVER['HTTP_HOST'];
}

function message($data)
{
    if (session("basephp-flash.$data")) {
        return session("basephp-flash.$data");;
    }
}

function messages($data)
{
    if (session("basephp-flash.$data")) {
        return true;
    } else {
        return false;
    }
}

function old($input)
{
    if (session("basephp-flash.inputs.$input")) {
        return session("basephp-flash.inputs.$input");
    } else {
        return null;
    }
}

function post($var = '')
{
    if ($var == '') {
        return $_POST;
    } else {
        if (isset($_POST[$var]) && $_POST[$var] != '') {
            return $_POST[$var];
        }
    }
}

function query_string()
{
    return $_SERVER['QUERY_STRING'];
}

function request($var = '')
{
    if ($var == '') {
        return $_REQUEST;
    }

    if (isset($_FILES[$var]) && $_FILES[$var] != '') {
        $storage = new Storage();
        $storage->content = $var;

        return $storage;
    }

    if (isset($_REQUEST[$var]) && $_REQUEST[$var] != '') {
        if (is_string($_REQUEST[$var])) {
            return $_REQUEST[$var];
        }

        if (is_array($_REQUEST[$var])) {
            return json_encode($_REQUEST[$var]);
        }
    }

    return null;
}

function server($var = '')
{
    $array['admin'] = $_SERVER['SERVER_ADMIN'] ?? null;
    $array['browser_visitor'] = $_SERVER['HTTP_USER_AGENT'] ?? null;
    $array['filename'] = $_SERVER['SCRIPT_FILENAME'] ?? null;
    $array['host'] = $_SERVER['HTTP_HOST'] ?? null;
    $array['ip_server'] = $_SERVER['SERVER_ADDR'] ?? null;
    $array['ip_visitor'] = $_SERVER['REMOTE_ADDR'] ?? null;
    $array['method'] = $_SERVER['REQUEST_METHOD'] ?? null;
    $array['protocol'] = $_SERVER['REQUEST_SCHEME'] ?? null;
    $array['query'] = $_SERVER['QUERY_STRING'] ?? null;
    $array['referer'] = $_SERVER['HTTP_REFERER'] ?? null;
    $array['root'] = $_SERVER['DOCUMENT_ROOT'] ?? null;
    $array['software'] = $_SERVER['SERVER_SOFTWARE'] ?? null;
    $array['uri'] = $_SERVER['REQUEST_URI'] ?? null;
    $array['user_agent'] = $_SERVER['HTTP_USER_AGENT']

    if ($var) {
        return $array[$var];
    }

    return $array;
}
