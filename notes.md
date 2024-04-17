# notes
## Installing xz
```bash
sudo apt install xz-utils
```
## Decompress xz file
```bash
xz -d updatev12-access-pseudonymized.log.xz
```
## Create log file with first 50 lines
```bash
head -50 updatev12-access-pseudonymized.log > first50.log
```
## Read log file line by line
```php
<?php declare(strict_types=1);

$file_handle = fopen(
    filename: '../data/first50.log',
    mode: 'r'
);

/**
 * @param $file_handle
 * @return Generator
 */
function getAllLines($file_handle) : Generator
{
    while (!feof($file_handle)) {
        yield fgets($file_handle);
    }
}

$count = 0;
foreach (getAllLines($file_handle) as $line) {
    echo $line;
}
fclose($file_handle);
```
## Run time behaviour
Found the time killer. Maybe it's a bad idea to use the licence class. I need the
serial number and the counter. What about two arrays instead of one object?