<?php declare(strict_types=1);

/**
 * This generator iterates over the log file
 */
class LogEntryGenerator
{
    /**
     * @var
     */
    private $handle;

    /**
     * @param $handle
     */
    public function __construct(
        $handle
    )
    {
        $this->handle = $handle;
    }

    /**
     * @return Generator
     */
    public function execute() : Generator
    {
        while (!feof($this->handle)) {
            yield fgets($this->handle);
        }
    }
}
