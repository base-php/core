<?php

namespace App\Commands;

class CommandName extends Command
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    public string $name = '';

    /**
     * The console command description.
     *
     * @var string
     */
    public string $description = '';

    /**
     * Set console arguments.
     *
     * @return array
     */
    public function params(): array
    {
        return [];
    }

    /**
     * Execute the console command.
     *
     * @param  object  $params
     * @return mixed
     */
    public function handle(object $params): mixed
    {
        
    }
}
