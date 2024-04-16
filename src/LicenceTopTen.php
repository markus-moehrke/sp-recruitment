<?php declare(strict_types=1);

class LicenceTopTen
{
    private array $ranking;

    public function __construct()
    {
        $this->ranking = [];
    }

    public function add(Licence $licence) : void
    {
        $key = $this->inArray($licence);
        if (is_null($key)) {
            // Add licence
            $this->ranking[] = $licence;
        } else {
            // Increment counter
            ($this->ranking[$key])->setCounter(
                counter: ($this->ranking[$key])->getCounter()+1
            );
        }
    }

    public function getTop10() : array
    {
        $this->sort();
        return array_slice($this->ranking, 0, 10);
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

    /**
     * Sorts ranking list
     *
     * @return void
     */
    private function sort() : void
    {
        usort($this->ranking, [LicenceTopTen::class, 'compare']);
    }

    /**
     * Compare function for sort
     *
     * @param Licence $a
     * @param Licence $b
     * @return int
     */
    private function compare(Licence $a, Licence $b) : int
    {
        if ($a->getSerial() === $b->getSerial()) {
            return 0;
        }

        return ($a->getSerial() < $b->getSerial()) ? -1 : 1;
    }
}
