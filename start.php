<?php declare(strict_types=1);

const LOG_PATH = './data/firstRow.log';#'./data/first50.log';

function customAutoloader(string $class) : void
{
    include 'src/' . $class . '.php';
}

spl_autoload_register(callback: 'customAutoloader');


try {
    if ($handle = fopen(
        filename: LOG_PATH,
        mode: 'r'
    )) {
        $generator = new LogEntryGenerator($handle);
        $splitter = new LogSplitter();

        $count = 0;
        foreach ($generator->execute() as $line) {
            if (is_string($line)) {
                $splitted = $splitter->execute($line);
                print_r($splitted);
            }
        }
    } else {
        throw new Exception(message: 'Unable to open file');
    }
} catch (Throwable $t) {
    echo 'Error: ' . $t . PHP_EOL;
}

