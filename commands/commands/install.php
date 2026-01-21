<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'install', description: '')]
class Install extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $frontend = $style->choice(
            '¿Qué frontend te gustaría instalar?',
            ['Tailwind', 'Bootstrap']
        );

        $database = $style->choice(
            '¿Qué base de datos utilizará su aplicación?',
            ['SQLite', 'MySQL', 'PostgreSQL', 'SQL Server']
        );

        $databases = [
            'SQLite' => 'sqlite',
            'MySQL' => 'mysql',
            'PostgreSQL' => 'pgsql',
            'SQL Server' => 'sqlsrv'
        ];

        $content = file_get_contents('app/config.php');
        $content = str_replace('sqlite', $databases[$database], $content);

        file_put_contents('app/config.php', $content);

        return Command::SUCCESS;
    }
}
