<?php

use Netflie\Componentes\Componentes;

class View
{
    public $data = [];

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

            $file = $_SERVER['DOCUMENT_ROOT'] . '/vendor/base-php/core/packages/' . $path . '/views/' . $view . '.blade.php';
            $file = str_replace('packages/pagination', 'pagination', $file);

            if (file_exists($file)) {
                $view = file_get_contents($file);
                $find = true;
            }

        } else {
            $viewPath = $view;
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $view . '.blade.php')) {
                $view = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $view . '.blade.php');
                $find = true;
            }
        }

        if ($find == false) {
            $view = str_replace('/', '.', $view);
            throw new Exception("View [$view] not found");
        }
        
        $viewComposers = scandir($_SERVER['DOCUMENT_ROOT'] . '/app/View/Composers');
        array_shift($viewComposers);
        array_shift($viewComposers);

        $viewComposers = array_map(function ($item) {
            return 'App\View\Composers\\' . str_replace('.php', '', $item);
        }, $viewComposers);
        
        foreach ($viewComposers as $composer) {
            $instance = new $composer();

            $instanceView = str_replace('.', '/', $instance->view);

            if ($instanceView == $viewPath) {
                $instance->compose($this);
            }
        }

        $data = array_merge($this->data, $data);

        echo $componentes->render($view, $data);

        $_ENV['view'] = true;

        return $this;
    }

    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }
}
