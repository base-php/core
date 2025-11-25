<?php

class Module
{
    public $modules;

    public function __construct()
    {
        $this->modules = [];

        foreach (scandir('modules') as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            if (is_dir('modules' . '/' . $module)) {
                $this->modules[] = $module;
            }
        }
    }

    public function collection()
    {
        return collect($this->modules);
    }

    public function has($module)
    {
        return in_array($module, $this->modules);
    }

    public function all()
    {
        return $this->modules;
    }
}
