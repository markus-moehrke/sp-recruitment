<?php declare(strict_types=1);

class LicenceTopTen
{
    private array $ranking;

    public function __construct()
    {
        $this->ranking = [];
    }

    /**
     * Checks if licence is already in list.
     * If yes, increment counter.
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
            // Increment counter
            ($this->ranking[$key])->incrementCounter();
        }
    }

    public function getTop10() : array
    {
        $this->sort();

        return array_slice(array: $this->ranking, offset: 0, length: 10);
    }

    /**
     * This is the time killer: searching in array for object
     * @param Licence $licence
     * @return int|null
     */
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

    /**
     * Sorts ranking list
     *
     * @return void
     */
    private function sort() : void
    {
        usort(array: $this->ranking, callback: [Licence::class, 'compare']);
    }
}
