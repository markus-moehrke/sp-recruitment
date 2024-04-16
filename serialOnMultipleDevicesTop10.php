<?php declare(strict_types=1);

const LOG_PATH = './data/first50000.log';

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

        foreach ($generator->execute() as $line) {
            if (is_string($line)) {
                $separated = $splitter->execute(line: $line);
                if (isset($separated['serial']) && isset($separated['ip'])) {
                    $licence = new Licence($separated['serial']);
                    $licence->addIp(ip: $separated['ip']);
                    $multipleDevices->add(licence: $licence);
                }
            }
        }

        $top10 = $multipleDevices->getTop10();
        print_r($top10);
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
