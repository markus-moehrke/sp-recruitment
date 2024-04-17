<?php declare(strict_types=1);

class LogSplitter
{
    /**
     * @param string $line
     * @return string[]
     * @throws Exception
     */
    public function execute(string $line) : array
    {
        $separated = $this->initArray();

        $array = explode(separator: '"', string: trim($line));
        if (count($array) < 3) {
            return [];
        } else {
            $left = $array[0];
            $right = $array[2];
        }
        if (isset($left)) {
            $array = explode(separator: ' ', string: trim($left));
            if (count($array) < 3) {
                return [];
            } else {
                $separated['ip'] = $array[0];
            }
            if (isset($right)) {
                $array = explode(separator: ' ', string: trim($right));
                if (count($array) < 7) {
                    return [];
                } else {
                    $separated['serial'] = $array[4];
                }
            }
        } else {
            throw new Exception(message: 'line is malformed');
        }

        return $separated;
    }

    /**
     * @return string[]
     */
    private function initArray() : array
    {
        return [
            'ip' => '',
            'servername' => '',
            'date' => '',
            'protocol' => '',
            'status' => '',
            'size' => '',
            'proxy' => '',
            'rt' => '',
            'serial' => '',
            'version' => '',
            'specs' => '',
        ];
    }
}
