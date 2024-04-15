<?php declare(strict_types=1);

function customAutoloader(string $class) : void
{
    include 'src/' . $class . '.php';
}

spl_autoload_register(callback: 'customAutoloader');

$foo = new Foo();
