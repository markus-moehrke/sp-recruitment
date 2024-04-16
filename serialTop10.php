<?php declare(strict_types=1);

#const LOG_PATH = './data/firstRow.log';
const LOG_PATH = './data/first4.log';
#const LOG_PATH = './data/first50.log';       // 0.003805081
#const LOG_PATH = './data/first500.log';      // 0.181668679
#const LOG_PATH = './data/first5000.log';     // 15.766691089
#const LOG_PATH = './data/first50000.log';
#const LOG_PATH = './data/first500000.log';
#const LOG_PATH = './data/first5000000.log';
#const LOG_PATH = './data/updatev12-access-pseudonymized.log';

//------------------------------------------------------------------------------
// Auto loader

/**
 * @param string $class
 * @return void
 */
function customAutoloader(string $class) : void
{
    include 'src/' . $class . '.php';
}

spl_autoload_register(callback: 'customAutoloader');

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

        $count = 0;
        foreach ($generator->execute() as $line) {
            if (is_string($line)) {
                $separated = $splitter->execute(line: $line);
                if (isset($separated['serial'])) {
                    $licences->add(
                        new Licence($separated['serial'])
                    );
                }
            }
        }
        print_r(
            $licences->getTop10()
        );
    } else {
        throw new Exception(message: 'Unable to open file');
    }
} catch (Throwable $t) {
    echo sprintf(
        'Error: %s %s',
        $t,
        PHP_EOL
    );
}

$benchmark->stop();
echo $benchmark->getDiff() . PHP_EOL;
