<?php

namespace db\adapters;

use vendor\db\DB;

class MYSQLAdapter extends DB
{
    protected  $pdo;

    private $options;

    public function __construct($options)
    {
        try {
            $this->pdo = new \PDO($options['scheme'] . ':' . 'host=' . $options['host'] . ';dbname=' . $options['db'], $options['user'], $options['pass']);
        } catch
        (\PDOException $e) {
            print "Error connect to MySql !: " . $e->getMessage();
            die();
        }
    }

    public function getTableInformation($table)
    {
        $res = $this->pdo->query('SHOW COLUMNS FROM ' . $table);
        return  $res->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function checkTableExist($table)
    {
        if (!$this->pdo->query('show tables like "' . trim($table) . '"')) {
            throw new \Exception('Table with name ' . $table . ' is not exist');
        }
    }
}