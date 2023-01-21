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
    $index = array_search($data, $_SESSION['basephp-flash']['errors']);
    unset($_SESSION['basephp-flash']['errors'][$index]);
}

function errors()
{
    if (isset($_SESSION['basephp-flash']['errors'])) {
        return $_SESSION['basephp-flash']['errors'];
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

function host()
{
    return '//'.$_SERVER['HTTP_HOST'];
}

function message($data)
{
    if (isset($_SESSION['basephp-flash'][$data])) {
        return $_SESSION['basephp-flash'][$data];
    }
}

function messages($data)
{
    if (isset($_SESSION['basephp-flash'][$data])) {
        return true;
    } else {
        return false;
    }
}

function old($input)
{
    if (isset($_SESSION['basephp-flash']['inputs'][$input])) {
        return $_SESSION['basephp-flash']['inputs'][$input];
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
    } else {
        if (isset($_FILES[$var]) && $_FILES[$var] != '') {
            $storage = new Storage();
            $storage->content = $var;

            return $storage;
        }

        if (isset($_REQUEST[$var]) && $_REQUEST[$var] != '') {
            return $_REQUEST[$var];
        }
    }
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

    if ($var) {
        return $array[$var];
    }

    return $array;
}
