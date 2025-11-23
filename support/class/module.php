<?php

class Module
{
    public function all()
    {
        $modules = [];

        foreach (scandir('modules') as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            if (is_dir('modules' . '/' . $module)) {
                $modules[] = $module;
            }
        }

        return $modules;
    }
}
