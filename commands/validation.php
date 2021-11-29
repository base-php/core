<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeValidation extends Command
{
    protected static $defaultName = 'make:validation';

    protected static $defaultDescription = 'Create a validation file with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Validation.php');
        $content = str_replace('ValidationName', $name, $content);

        if (!file_exists('app/Validations')) {
            mkdir('app/Validations');
        }

        $fopen = fopen('app/Validations/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>Validation '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
