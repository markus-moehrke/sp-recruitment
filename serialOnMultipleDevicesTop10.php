<?php declare(strict_types=1);

const LOG_PATH = './data/updatev12-access-pseudonymized.log';

//------------------------------------------------------------------------------
// Auto loader
include 'src/AutoLoader.php';

$auto = new AutoLoader();
$auto->execute();

//------------------------------------------------------------------------------

$benchmark = new Benchmark();
$benchmark->start();

try {
    if ($handle = fopen(
        filename: LOG_PATH,
        mode: 'r'
    )) {
        $generator = new LogEntryGenerator($handle);
        $splitter = new LogSplitter();
        $multipleDevices = new MultipleDevicesTop10();

        $count = 0;
        $malformed = 0;
        foreach ($generator->execute() as $line) {
            if (is_string($line)) {
                $separated = $splitter->execute(line: $line);
                if (isset($separated['serial']) && isset($separated['ip'])) {
                    $multipleDevices->add(
                        serial: $separated['serial'],
                        ip: $separated['ip']
                    );
                } else {
                    $malformed++;
                }
            }
            $count++;
        }

        $top10 = $multipleDevices->getTop10();
        print_r($top10);
        print $count . '/' . $malformed . PHP_EOL;
    } else {
        throw new Exception(message: 'Unable to open file');
    }
} catch (Throwable $t) {
    echo sprintf(
        'Error: %s %s',
        $t->getMessage(),
        PHP_EOL
    );
}

$benchmark->stop();
echo $benchmark->getDiff() . PHP_EOL;
