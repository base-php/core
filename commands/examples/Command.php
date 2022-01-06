<?php

namespace App\Commands;

class CommandName extends Command
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    public $name = '';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Set console arguments.
     *
     * @return array
     */
    public function params()
    {
        return [];
    }

    /**
     * Execute the console command.
     *
     * @param  object $params
     * @return mixed
     */
    public function handle($params)
    {

    }
}
