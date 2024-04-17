<?php declare(strict_types=1);

/**
 * A licence saves data about serial numbers
 */
class Licence
{
    /**
     * @var int
     */
    private int $counter;

    /**
     * @var string
     */
    private string $serial;

    /**
     * @var int
     */
    private int $ipCounter;

    /**
     * @var int[]
     */
    private array $ips;

    /**
     * @param string $serial
     */
    public function __construct(string $serial)
    {
        $this->counter = 1;
        $this->serial = $serial;
        $this->ips = [];
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * @param int $counter
     * @return void
     */
    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }

    /**
     * @return void
     */
    public function incrementCounter() : void
    {
        $this->counter = $this->counter+1;
    }

    /**
     * @return string
     */
    public function getSerial(): string
    {
        return $this->serial;
    }

    /**
     * @param string $serial
     * @return void
     */
    public function setSerial(string $serial): void
    {
        $this->serial = $serial;
    }

    /**
     * @return array
     */
    public function getIps(): array
    {
        return $this->ips;
    }

    /**
     * @param array $ips
     * @return void
     */
    public function setIps(array $ips): void
    {
        $this->ips = $ips;
    }

    /**
     * @param string $ip
     * @return void
     */
    public function addIp(string $ip) : void
    {
        if (!in_array(needle: $ip, haystack: $this->ips)) {
            $this->ips[] = $ip;
        }
    }

    /**
     * @return int
     */
    public function getIpCounter(): int
    {
        return $this->ipCounter;
    }

    /**
     * @param int $ipCounter
     * @return void
     */
    public function setIpCounter(int $ipCounter): void
    {
        $this->ipCounter = $ipCounter;
    }

    /**
     * @param Licence $b
     * @param Licence $a
     * @return int
     */
    public static function compare(Licence $b, Licence $a) : int
    {
        return
            strtolower((string)$a->getCounter())
            <=>
            strtolower((string)$b->getCounter());
    }
}
