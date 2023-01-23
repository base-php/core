<?php

use Netflie\Componentes\Componentes;

class View
{
    public function __toString()
    {
        return '';
    }

    public function render($view, $data = [])
    {
        $viewPath = realpath($_SERVER['DOCUMENT_ROOT'].'/resources/views');
        $componentes = Componentes::create($viewPath);

        $view = str_replace('.', '/', $view);

        $find = false;

        if (strpos($view, ':')) {
            $array = explode(':', $view);

            $path = $array[0];
            $view = $array[1];

            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/vendor/base-php/core/' . $path . '/views/' . $view . '.blade.php')) {
                $view = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/vendor/base-php/core/http/views/' . $view . '.blade.php');
                $find = true;
            }

        } else {
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/resources/views/' . $view . '.blade.php')) {
            $view = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/views/' . $view . '.blade.php');
            $find = true;
        }
        }

        if ($find == false) {
            $view = str_replace('/', '.', $view);
            throw new Exception("View [$view] not found");
        }

        echo $componentes->render($view, $data);

        $_ENV['view'] = true;

        return $this;
    }
}
