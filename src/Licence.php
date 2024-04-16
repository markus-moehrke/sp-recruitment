<?php

class Licence
{
    private int $counter;
    private string $serial;

    public function __construct(string $serial)
    {
        $this->counter = 1;
        $this->serial = $serial;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }

    public function getSerial(): string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): void
    {
        $this->serial = $serial;
    }
}
