<?php
/**
 * Created by PhpStorm.
 * User: rbabenko
 * Date: 03.02.2017
 * Time: 17:35
 */

namespace vendor\components;


class Alias
{
    private static $aliases = [
      
    ];

    public static function getAlias($aliasName)
    {
        return self::$aliases[$aliasName];
    }

    public static function setAlias($aliasName, $aliasValue)
    {
        self::$aliases[$aliasName] = $aliasValue;
    }
}