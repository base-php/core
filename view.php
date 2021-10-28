<?php

use Netflie\Componentes\Componentes;

class View
{
    /**
     * Necessary method for Symfony class.
     *
     * @return void
     */
    public function __toString()
    {
        return '';
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @return View
     */
    public function render(string $view, array $data = []): View
    {
        $viewPath = realpath($_SERVER['DOCUMENT_ROOT'] . '/resources/views');
        $componentes = Componentes::create($viewPath);

        $view = str_replace('.', '/', $view);

        if ($view == 'recover') {
            $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/nisadelgado/framework/third/views/' . $view . '.blade.php');
        } else if ($view == '401') {
            $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/nisadelgado/framework/third/views/' . $view . '.blade.php');
        } else {
            $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $view . '.blade.php');
        }

        echo $componentes->render($view, $data);

        $_ENV['view'] = true;

        return $this;
    }
}
