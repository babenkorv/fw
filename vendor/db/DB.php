<?php

namespace vendor\db;

class DB extends DataBaseConnect
{
    /**
     * Execute a raw SQL query on the database.
     *
     * @param $sql
     * @return array
     */
    public function query($sql, $values = [])
    {

        if (!$sth = $this->pdo->prepare($sql)) {
            throw new \Exception('Database Error: query is not a prepare');
        }
        
        if (!$sth->execute($values)) {
            throw new \Exception('Database Error: query is not a execute');
        }
        return $sth;
    }

    /**
     * Run the query and returns all the rows found.
     *
     * @param string $sql Raw SQL string to execute.
     * @param array &$values Optional array of values to bind to the query.
     * @return string
     */
    public function findAll($sql, $values = [])
    {
        $sth = $this->query($sql, $values);
        $row = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $row;
    }

    /**
     * Run the query and returns first row.
     *
     * @param string $sql Raw SQL string to execute.
     * @param array &$values Optional array of values to bind to the query.
     * @return string
     */
    public function findOne($sql, $values = [])
    {
        $sth = $this->query($sql, $values);
        $row = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $row[0];
    }


   
}