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
        echo $_SESSION['flashmessages'][$data];
        unset($_SESSION['flashmessages']);
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
        echo $_SESSION['flashmessages']['inputs'][$input];
        unset($_SESSION['flashmessages']['inputs'][$input]);
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
    if ($var == '') {
        return $_SERVER;
    }

    return $_SERVER[$var];
}
