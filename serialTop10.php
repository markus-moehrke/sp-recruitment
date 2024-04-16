<?php declare(strict_types=1);

const LOG_PATH = './data/first500.log';      // 0.181668679
#const LOG_PATH = './data/updatev12-access-pseudonymized.log';

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
        $licences = new LicenceTopTen();

        foreach ($generator->execute() as $line) {
            if (is_string($line)) {
                $separated = $splitter->execute(line: $line);
                if (isset($separated['serial'])) {
                    $licences->add(
                        licence: new Licence($separated['serial'])
                    );
                }
            }
        }

        $top10 = $licences->getTop10();
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
