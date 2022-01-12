<?php

class Backup
{
    public $connection;

    public function __construct($connection = 'default')
    {
        $config = include 'app/config.php';
        $name = array_column($config['database'], 'name');
        $connection = array_search($connection, $name);
        $this->connection = $config['database'][$connection];
    }

    public function filename($filename)
    {
        if ($this->connection['driver'] == 'mysql') {
            $host = $this->connection['host'];
            $username = $this->connection['username'];
            $password = $this->connection['password'];
            $database = $this->connection['database'];

            system("mysqldump --host=$host --user=$username --password=$password $database > $filename");
        }
    }
}
