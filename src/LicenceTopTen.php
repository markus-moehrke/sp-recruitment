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
        #echo 'before sorting' . PHP_EOL;
        #print_r($this->ranking);

        $this->sort();

        #echo 'after sorting' . PHP_EOL;
        #print_r($this->ranking);

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
    private function sort() : void# vielleicht die falsche sortierung? das sind strings!
    {
        usort($this->ranking, [Licence::class, 'compare']);
    }
}
