<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'feature:purge', description: 'Eliminar features del almacenamiento')]
class FeaturePurge extends Command
{
    public function configure()
    {
        $this->addArgument('features', InputArgument::OPTIONAL, 'Features a eliminar');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        $features = $input->getArgument('features');

        if ($features) {
            $features = explode(',', $features);

            DB::table('features')
                ->whereIn('name', $features)
                ->delete();

        } else {
            DB::table('features')->delete();
        }

        $style = new SymfonyStyle($input, $output);
        $style->info('Los features se eliminaron correctamente del almacenamiento.');

        return Command::SUCCESS;
    }
}
