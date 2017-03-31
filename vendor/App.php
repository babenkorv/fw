<?php

namespace vendor;

class App
{
    public static $container;

    public function run($config)
    {
        self::$container = new Container($config);
    }
}