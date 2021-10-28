<?php

/**
 * Verify if the request is ajax.
 *
 * @return bool
 */
function ajax(): bool
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        return true;
    }

    return false;
}

/**
 * Displays the validation text and subsequently deletes it from the session.
 * 
 * @param string $data
 * 
 * @return void
 */
function error(string $data): void
{
    echo $data;
    $index = array_search($data, $_SESSION['flashmessages']['errors']);
    unset($_SESSION['flashmessages']['errors'][$index]);
}

/**
 * Errors of validations.
 * 
 * @return void
 */
function errors()
{
    if (isset($_SESSION['flashmessages']['errors'])) {
        return $_SESSION['flashmessages']['errors'];
    }
}

/**
 * Return GET request.
 *
 * @param  string $var
 * @return array|string
 */
function get(string $var = ''): array|string
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
 * Get host name.
 *
 * @return string
 */
function host(): string
{
    return '//' . $_SERVER['HTTP_HOST'];
}

/**
 * Get a flash message and delete this.
 *
 * @param  string $data
 * @return void
 */
function message(string $data): void
{
    if (isset($_SESSION['flashmessages'][$data])) {
        echo $_SESSION['flashmessages'][$data];
        unset($_SESSION['flashmessages']);
    }
}

/**
 * Verify if have a flash message.
 *
 * @param  string $data
 * @return bool
 */
function messages(string $data): bool
{
    if (isset($_SESSION['flashmessages'][$data])) {
        return true;
    } else {
        return false;
    }
}

/**
 * Show data for input when validation fail.
 * 
 * @param string $input
 * @return void|null
 */
function old(string $input)
{
    if (isset($_SESSION['flashmessages']['inputs'][$input])) {
        echo $_SESSION['flashmessages']['inputs'][$input];
        unset($_SESSION['flashmessages']['inputs'][$input]);
    } else {
        return null;
    }
}

/**
 * Return POST request.
 *
 * @param  string $var
 * @return array|string
 */
function post(string $var = ''): array|string
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
 * Get query string.
 *
 * @return  string
 */
function query_string(): string
{
    return $_SERVER['QUERY_STRING'];
}

/**
 * Return request.
 *
 * @param  string $var
 * @return mixed
 */
function request(string $var = '')
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
