<?php declare(strict_types=1);

class MultipleDevicesTop10
{
    private array $ranking;

    public function __construct()
    {
        $this->ranking = [];
    }

    /**
     * Checks if licence is already in list.
     * If yes, checks if ip address matches the registered one.
     *         If no, add ip address and increment counter.
     * If no, add new entry to list.
     *
     * @param Licence $licence
     * @return void
     */
    public function add(Licence $licence) : void
    {
        $key = $this->inArray($licence);
        if (is_null($key)) {
            // Add licence
            $this->ranking[] = $licence;
        } else {
            /** @var Licence $rankingLicence */
            $rankingLicence = $this->ranking[$key];
            $currentLicenceIps = $licence->getIps()[0];
            if (!in_array(
                needle: $currentLicenceIps,
                haystack: $rankingLicence->getIps())
            ) {
                $rankingLicence->addIp($currentLicenceIps);
                $rankingLicence->incrementCounter();
            }
        }
    }

    public function getTop10() : array
    {
        $this->sort();

        return array_slice(array: $this->ranking, offset: 0, length: 10);
    }

    private function inArray(Licence $licence) : ?int
    {
        $searchedValue = $licence->getSerial();

        $filteredArray = array_filter(
            $this->ranking,
            function (Licence $current) use ($searchedValue) {
                return $current->getSerial() === $searchedValue;
            }
        );

        return array_key_first($filteredArray);
    }

    private function sort() : void
    {
        usort(array: $this->ranking, callback: [Licence::class, 'compare']);
    }
}
