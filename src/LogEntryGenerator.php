<?php declare(strict_types=1);

class LogEntryGenerator
{
    private $handle;

    public function __construct(
        $handle
    )
    {
        $this->handle = $handle;
    }

    public function execute() : Generator
    {
        while (!feof($this->handle)) {
            yield fgets($this->handle);
        }
    }
}
