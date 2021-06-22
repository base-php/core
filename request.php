<?php

/**
 * Show data for input when validation fail.
 * 
 * @param string $input
 * 
 * @return string
 */
function old($input)
{
    if (isset($_SESSION['flashmessages']['inputs'][$input])) {
        echo $_SESSION['flashmessages']['inputs'][$input];
        unset($_SESSION['flashmessages']['inputs'][$input]);
    } else {
        return null;
    }
}

/**
 * Errors of validations.
 * 
 * @return errors
 */
function errors()
{
    if (isset($_SESSION['flashmessages']['errors'])) {
        return $_SESSION['flashmessages']['errors'];
    }
}

/**
 * Displays the validation text and subsequently deletes it from the session.
 * 
 * @param string $data
 * 
 * @return error
 */
function error($data)
{
    echo $data;
    $index = array_search($data, $_SESSION['flashmessages']['errors']);
    unset($_SESSION['flashmessages']['errors'][$index]);
}

/**
 * Verify if have a flash message.
 *
 * @param  string $data
 * @return boolean
 */
function messages($data)
{
    if (isset($_SESSION['flashmessages'][$data])) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get a flash message and delete this.
 *
 * @param  string $data
 * @return string
 */
function message($data)
{
    if (isset($_SESSION['flashmessages'][$data])) {
        echo $_SESSION['flashmessages'][$data];
        unset($_SESSION['flashmessages']);
    }
}

/**
 * Verify if active module in menu.
 *
 * @param  string $module
 * @return string
 */
function active($module)
{
    if ($module == '/') {
        echo ($_SERVER['REQUEST_URI'] == '/') ? 'active' : '';
    } else {
        echo (strpos($_SERVER['REQUEST_URI'], $module) == !false) ? 'active' : '';
    }
}

/**
 * Return POST request.
 *
 * @param  string $var
 * @return mixed
 */
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

/**
 * Return GET request.
 *
 * @param  string $var
 * @return mixed
 */
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

/**
 * Verify if the request is ajax.
 *
 * @return boolean
 */
function ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']);
}

/**
 * Get query string.
 *
 * @return  string
 */
function query_string()
{
    return $_SERVER['QUERY_STRING'];
}

/**
 * Get host name.
 *
 * @return string
 */
function host()
{
    return '//' . $_SERVER['HTTP_HOST'];
}
