<?php

use Symfony\Component\Console\Command\Command;

class Inspire extends Command
{
    protected static $defaultName = 'inspire';

    protected static $defaultDescription = 'Display an inspiring quote';

    protected function execute($input, $output)
    {
        $quotes = file_get_contents('https://type.fit/api/quotes');
        $quotes = json_decode($quotes, true);

        $count = count($quotes);
        $rand = rand(0, $count);

        $quote = $quotes[$rand]['text'];
        $author = $quotes[$rand]['author'];

        $output->writeln('');
        $output->writeln("\"$quote\"");
        $output->writeln("- $author");
        $output->writeln('');

        return Command::SUCCESS;
    }
}
