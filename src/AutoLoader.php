<?php

class AutoLoader
{
    public function execute() : void
    {
        spl_autoload_register(callback: [AutoLoader::class, 'customAutoloader']);
    }

    private static function customAutoloader(string $class) : void
    {
        include 'src/' . $class . '.php';
    }
}
