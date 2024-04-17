<?php declare(strict_types=1);

/**
 * Container for licences from second task
 */
class MultipleDevicesTop10
{
    /**
     * @var Licence[]
     */
    private array $ranking;

    /**
     * @var string[]
     */
    private array $serial;

    /**
     * @var int[]
     */
    private array $counter;

    /**
     * @var int[][]
     */
    private array $ips;

    /**
     *
     */
    public function __construct()
    {
        $this->serial = [];
        $this->counter = [];
        $this->ranking = [];
        $this->ips = [];
    }

    /**
     * Checks if licence is already in list.
     * If yes, checks if ip address matches the registered one.
     *         If no, add ip address and increment counter.
     * If no, add new entry to list.
     *
     * @param string $serial
     * @param string $ip
     * @return void
     */
    public function add(string $serial, string $ip) : void
    {
        $key = array_search(needle: $serial, haystack: $this->serial);
        if ($key === false) {
            // Add licence
            $this->serial[] = $serial;
            $this->counter[] = 1;
            $this->ips[][] = $ip;
        } else {
            if (!in_array(needle: $ip, haystack: $this->ips[$key])) {
#            if ($this->ips[$key] !== $ip) {
                $this->counter[$key] = $this->counter[$key] + 1;
                $this->ips[$key][] = $ip;
            }
            /** @var Licence $rankingLicence
            $rankingLicence = $this->ranking[$key];
            $currentLicenceIps = $licence->getIps()[0];
            if (!in_array(
                needle: $currentLicenceIps,
                haystack: $rankingLicence->getIps())
            ) {
                $rankingLicence->addIp($currentLicenceIps);
                $rankingLicence->incrementCounter();
            }*/
        }
    }

    /**
     * @return array
     */
    public function getTop10() : array
    {
        $this->boxing();
        $this->sort();

        return array_slice(array: $this->ranking, offset: 0, length: 10);
    }

    /**
     * @return void
     */
    private function boxing() : void
    {
        foreach ($this->serial as $index => $record) {
            $licence = new Licence(serial: $record);
            $licence->setCounter($this->counter[$index]);
            $licence->setIps($this->ips[$index]);
            $licence->setIpCounter(count($this->ips[$index]));
            $this->ranking[] = $licence;
        }
    }

    /**
     * @return void
     */
    private function sort() : void
    {
        usort(array: $this->ranking, callback: [Licence::class, 'compare']);
    }
}
