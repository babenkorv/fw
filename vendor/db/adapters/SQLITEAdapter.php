<?php

namespace db\adapters;

use vendor\db\DB;

class SQLITEAdapter extends DB
{

    private $options;

    public function __construct($options)
    {
        try {
            $this->pdo = new \PDO($options['scheme'] . ':' . $options['path']);
        } catch
        (\PDOException $e) {
            print "Error connect to SQLite !: " . $e->getMessage();
            die();
        }
    }

    public function getTableInformation($table)
    {
        $res = $this->pdo->query("pragma table_info($table)");

        $res = $res->fetchAll(\PDO::FETCH_ASSOC);
        $fields = [];

        foreach ($res as $filed) {
            $fields[]['Field'] = $filed['name'];
        }
        return $fields;
    }

    public function checkTableExist($table)
    {
        $res = $this->pdo->query("SELECT * FROM sqlite_master where name =" . "'" . $table . "'");
        
        $res = $res->fetchAll(\PDO::FETCH_ASSOC);

        if (!empty($row)) {
            throw new \Exception('Table with name ' . $table . ' is not exist');
        }
    }
}