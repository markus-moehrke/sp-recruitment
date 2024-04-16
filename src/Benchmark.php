<?php declare(strict_types=1);

class Benchmark
{
    private float $start;
    private float $stop;

    public function __construct()
    {
        $this->start = $this->stop = 0;
    }

    public function start() : void
    {
        $this->start = microtime(as_float: true);
    }

    public function stop() : void
    {
        $this->stop = microtime(as_float: true);
    }

    public function getDiff() : float
    {
        return $this->stop - $this->start;
    }
}
