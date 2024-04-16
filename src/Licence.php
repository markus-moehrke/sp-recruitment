<?php declare(strict_types=1);

class Licence
{
    private int $counter;
    private string $serial;
    private array $ips;

    public function __construct(string $serial)
    {
        $this->counter = 1;
        $this->serial = $serial;
        $this->ips = [];
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }

    public function incrementCounter() : void
    {
        $this->counter = $this->counter+1;
    }

    public function getSerial(): string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): void
    {
        $this->serial = $serial;
    }

    public function getIps(): array
    {
        return $this->ips;
    }

    public function setIps(array $ips): void
    {
        $this->ips = $ips;
    }

    public function addIp(string $ip) : void
    {
        if (!in_array(needle: $ip, haystack: $this->ips)) {
            $this->ips[] = $ip;
        }
    }

    public static function compare(Licence $b, Licence $a) : int
    {
        return
            strtolower((string)$a->getCounter())
            <=>
            strtolower((string)$b->getCounter());
    }
}
