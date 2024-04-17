<?php declare(strict_types=1);

/**
 * A simple autoloader to prevent too much includes.
 */
class AutoLoader
{
    /**
     * @return void
     */
    public function execute() : void
    {
        spl_autoload_register(callback: [AutoLoader::class, 'customAutoloader']);
    }

    /**
     * @param string $class
     * @return void
     */
    private static function customAutoloader(string $class) : void
    {
        include 'src/' . $class . '.php';
    }
}
