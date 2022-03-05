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
    $index = array_search($data, $_SESSION['flashmessages']['errors']);
    unset($_SESSION['flashmessages']['errors'][$index]);
}

function errors()
{
    if (isset($_SESSION['flashmessages']['errors'])) {
        return $_SESSION['flashmessages']['errors'];
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
    return '//' . $_SERVER['HTTP_HOST'];
}

function message($data)
{
    if (isset($_SESSION['flashmessages'][$data])) {
        return $_SESSION['flashmessages'][$data];
    }
}

function messages($data)
{
    if (isset($_SESSION['flashmessages'][$data])) {
        return true;
    } else {
        return false;
    }
}

function old($input)
{
    if (isset($_SESSION['flashmessages']['inputs'][$input])) {
        return $_SESSION['flashmessages']['inputs'][$input];
    } else {
        return null;
    }
}

function post( $var = '')
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
    $array['admin']             = $_SERVER['SERVER_ADMIN'];
    $array['browser_visitor']   = $_SERVER['HTTP_USER_AGENT'];
    $array['filename']          = $_SERVER['SCRIPT_FILENAME'];
    $array['host']              = $_SERVER['HTTP_HOST'];
    $array['ip_server']         = $_SERVER['SERVER_ADDR'];
    $array['ip_visitor']        = $_SERVER['REMOTE_ADDR'];
    $array['method']            = $_SERVER['REQUEST_METHOD'];
    $array['protocol']          = $_SERVER['REQUEST_SCHEME'];
    $array['query']             = $_SERVER['QUERY_STRING'];
    $array['referer']           = $_SERVER['HTTP_REFERER'] ?? null;
    $array['root']              = $_SERVER['DOCUMENT_ROOT'];
    $array['software']          = $_SERVER['SERVER_SOFTWARE'];
    $array['uri']               = $_SERVER['REQUEST_URI'];

    if ($var) {
        return $array[$var];
    }

    return $array;
}
