<?php

namespace vendor\db;

class DataBaseConnect
{
    private static $instance = null;

    private static $accessScheme = [
        'mysql',
        'sqlite',
    ];

    private $connectOptions = [];
    private $adapter;

    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Create object DB class.
     * If @param string|array $connect string or array database connect data they will be used to connect to DB.
     * If @param null $connect is null data to connect to database will take with config
     *
     * @param array|string|null $connect connect DB data.
     * @return object Connect
     */
    public static function instance($connect)
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    private function __construct($connect = null)
    {
        if (!is_string($connect) && $connect !== null) {
            throw new \Exception('Connection string must have a string data type');
        }

        $this->setConnectOptions($connect);
        $SQLAdapter = self::loadAdapterClass($this->connectOptions['scheme']);

        $this->adapter = new $SQLAdapter($this->connectOptions);
    }

    /**
     * Check data to connect to database and save they to array @var $connectOptions .
     *
     * @param $connect connect DB data.
     * @throws \Exception
     */
    private function setConnectOptions($connect)
    {
        if (is_string($connect)) {
            $url = parse_url($connect);

            if (!isset($url['host']) || !isset($url['scheme'])) {
                throw new \Exception('Connection string must be specified in the connection string');
            }

            $this->connectOptions['scheme'] = $url['scheme'];
            $this->connectOptions['host'] = $url['host'];
            $this->connectOptions['db'] = isset($url['path']) ? $url['path'] : null;
            $this->connectOptions['user'] = isset($url['user']) ? $url['user'] : null;
            $this->connectOptions['pass'] = isset($url['pass']) ? $url['pass'] : null;
        }

        if ($connect == null) {
            $connectOption = require 'config/db.php';
            $dsn = $connectOption['dsn'];

            $this->connectOptions['scheme'] = explode(':', $dsn)[0];

            $dsn = str_replace($this->connectOptions['scheme'] . ':', '', $dsn);

            switch ($this->connectOptions['scheme']) {
                case 'mysql':
                    $dsn = explode(';',$dsn);
                    $this->connectOptions['host'] = explode('=', $dsn[0])[1];
                    $this->connectOptions['db'] = explode('=', $dsn[1])[1];
                    $this->connectOptions['user'] = isset($connectOption['user']) ? $connectOption['user'] : 'null';
                    $this->connectOptions['pass '] = isset($connectOption['pass']) ? $connectOption['pass'] : 'null';
                    break;
                case 'sqlite':
                    $this->connectOptions['path'] = $dsn;
                    break;
            }
        }

        if (is_array($connect)) {
            $this->connectOptions = $connect;
        }
    }

    /**
     * Load needed class with database.
     *
     * @param string $scheme database scheme.
     * @return mixed
     * @throws \Exception
     */
    private static function loadAdapterClass($scheme)
    {
        if (in_array(strtolower($scheme), self::$accessScheme)) {
            $class = strtoupper($scheme) . 'Adapter';

            $source = __DIR__ . "/adapters/$class.php";
            $class = 'db\adapters\\' . $class;
            if (file_exists($source)) {
                require_once $source;
                return $class;
            } else {
                throw new \Exception('Class with SQL adapter not found: ' . $source);
            }
        }
    }


   
}