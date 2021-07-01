<?php

/**
 * Get the evaluated view contents for the given view.
 *
 * @param  string  $view
 * @param  array   $data
 * @return Blade
 */
function view($view, $data = [])
{
	$viewPath = realpath($_SERVER['DOCUMENT_ROOT'] . '/resources/views');
	$componentes = Netflie\Componentes\Componentes::create($viewPath);

    if ($view == 'recover') {
        $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/nisadelgado/framework/third/views/' . $view . '.blade.php');
    } else if ($view == '401') {
        $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/nisadelgado/framework/third/views/' . $view . '.blade.php');
    } else {
        $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $view . '.blade.php');
    }

	echo $componentes->render($view, $data);
}
