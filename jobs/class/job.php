<?php

class Job
{
    public $job;

    public $queue;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function queue($queue)
    {
        $this->queue = $queue;

        return $this;
    }

    public function delay($date_reserve)
    {
        $this->date_reserve = strtotime($date_reserve);

        return $this;
    }

    public function __destruct()
    {
        $queue = isset($this->queue) ? $this->queue : 'default';

        $payload['job'] = get_class($this->job);
        $payload['params'] = $this->job;

        if (method_exists($this->job, 'tries')) {
            $payload['tries'] = $this->job->tries();
        }

        $payload = json_encode($payload);

        $date_reserve = isset($this->date_reserve) ? $this->date_reserve : time();

        $data = [
            'queue' => $queue,
            'payload' => $payload,
            'attempts' => 1,
            'date_reserve' => $date_reserve,
        ];

        DB::table('jobs')->insert($data);

        include 'vendor/base-php/core/database/database.php';

        $schema = $capsule->getConnection('default')->getSchemaBuilder();

        if ($schema->hasTable('monitor') && !strpos(currentRoute(), 'monitor')) {
            $monitor = new Monitor();
            $monitor->jobs($this, $this->queue, 'pending', null);
        }
    }
}
