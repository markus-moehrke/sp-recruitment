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

        //
        list(
            $left,
            $separated['protocol'],
            $right
            ) = explode(separator: '"', string: trim($line));
        if (isset($left)) {
            list(
                $separated['ip'],
                $separated['servername'],
                $separated['date']
                ) = explode(separator: ' ', string: trim($left));
            if (isset($right)) {
                list(
                    $separated['status'],
                    $separated['size'],
                    $separated['proxy'],
                    $separated['rt'],
                    $separated['serial'],
                    $separated['version'],
                    $separated['specs'],
                    ) = explode(separator: ' ', string: trim($right));
            }
        } else {
            throw new Exception('line is malformed');
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
