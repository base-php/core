<?php

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
 * Clear flash messages.
 *
 * @return void
 */
function clear()
{
    unset($_SESSION['flashmessages']);
}

/**
 * Get an redirector.
 *
 * @param  string  $location
 * @param  array   $data
 * @return string
 */
function redirect($location, $data = [])
{
    if ($data != []) {
        foreach ($data as $key => $value) {
            $_SESSION['flashmessages'][$key] = $value;
        }
    }
    echo '<script>window.location.href = "' . $location . '"</script>';
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
