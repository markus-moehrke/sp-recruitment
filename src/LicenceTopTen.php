<?php declare(strict_types=1);

/**
 * Container for licences from first task
 */
class LicenceTopTen
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
     *
     */
    public function __construct()
    {
        $this->serial = [];
        $this->counter = [];
        $this->ranking = [];
    }

    /**
     * Checks if licence is already in list.
     * If yes, increment counter.
     * If no, add new entry to list.
     *
     * @param string $serial
     * @return void
     */
    public function add(string $serial) : void
    {
        $key = array_search(needle: $serial, haystack: $this->serial);
        if ($key === false) {
            // Add licence
            $this->serial[] = $serial;
            $this->counter[] = 1;
        } else {
            // Increment counter
            $this->counter[$key] = $this->counter[$key] + 1;
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
     * Wraps data into licence object
     * @return void
     */
    private function boxing() : void
    {
        foreach ($this->serial as $index => $record) {
            $licence = new Licence(serial: $record);
            $licence->setCounter($this->counter[$index]);
            $this->ranking[] = $licence;
        }
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
