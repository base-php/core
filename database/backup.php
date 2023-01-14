<?php

// mysqldump and pg_dump must be added to the system environment variables.

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

        if ($this->connection['driver'] == 'pgsql') {
            $host = $this->connection['host'];
            $username = $this->connection['username'];
            $password = $this->connection['password'];
            $database = $this->connection['database'];

            system("pg_dump --dbname=postgresql://$username:$password@$host:5432/$database > $filename");
        }

        if ($this->connection['driver'] == 'sqlite') {
            $database = $this->connection['database'] . '.sqlite';
            $content = file_get_contents($database);
            $fopen = fopen($filename, 'w+');
            fwrite($fopen, $content);
            fclose($fopen);
        }
    }
}
