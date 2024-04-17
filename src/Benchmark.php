<?php declare(strict_types=1);

/**
 * A stop watch to measure the execution time of the scripts
 */
class Benchmark
{
    /**
     * @var float|int
     */
    private float $start;

    /**
     * @var float|int
     */
    private float $stop;

    /**
     *
     */
    public function __construct()
    {
        $this->start = $this->stop = 0;
    }

    /**
     * @return void
     */
    public function start() : void
    {
        $this->start = microtime(as_float: true);
    }

    /**
     * @return void
     */
    public function stop() : void
    {
        $this->stop = microtime(as_float: true);
    }

    /**
     * @return float
     */
    public function getDiff() : float
    {
        return $this->stop - $this->start;
    }
}
