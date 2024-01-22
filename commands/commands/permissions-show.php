<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'permissions:show', description: 'Muestra una tabla de roles y permisos')]
class PermissionsShow extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        include 'vendor/base-php/core/database/database.php';

        $headers = [];
        $rows = [];
        $i = 0;

        $roles = DB::table('roles')->get();

        if ($roles->count()) {
            $headers[] = '';
        }

        foreach ($roles as $role) {
            $headers[] = $role->name;
        }

        $permissions = DB::table('permissions')->get();

        foreach ($permissions as $permission) {
            $rows[$i][] = $permission->name;

            foreach ($roles as $role) {
                $result = DB::table('role_has_permissions')
                    ->where('id_role', $role->id)
                    ->where('id_permission', $permission->id)
                    ->get();

                $result = $result->count() ? 'x' : '';

                $rows[$i][] = new TableCell(
                    $result,
                    [
                        'style' => new TableCellStyle([
                            'align' => 'center',
                        ]),
                    ]
                );
            }

            $i++;
        }

        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->render();

        return Command::SUCCESS;
    }
}
