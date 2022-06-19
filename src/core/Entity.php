<?php

namespace Cms\core;
use \PDO;

abstract class Entity {

    public $dbc;
    public $tableName;
    public $id;

    public function __construct($dbConnection, $tableName) {
        $this->dbc = $dbConnection;
        $this->tableName = $tableName;
    }

    public function findBy($column, $value) {
        $stmt = $this->selectQuery($column, $value);
        $dataObj = $stmt->fetch(PDO::FETCH_OBJ);
        return $dataObj;
    }

    public function findAll() {
        $stmt = $this->selectQuery();
        $dataObjs = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $dataObjs;
    }

    public function findAllBy($column, $values) {

        $prepareString = '';

        foreach ($values as $value) {
            $prepareString .= $column. ' = ? OR ';
        }

        $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE ' . rtrim($prepareString, 'OR ');
        $stmt = $this->dbc->prepare($sql);
        $this->valuesBinder($stmt, $values);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function countRows() {
        $stmt = $this->selectQuery();
        $count = $stmt->rowCount();
        return $count;
    }

    public function getColumns() {
        $stmt = $this->selectQuery();
        $array = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_keys($array);
        
    }

    public function update(array $array, $id) {

        $prepareString = '';
        foreach ($this->getColumns() as $column) {
            if(!array_key_exists($column, $array)) {
                continue;
            }
            $prepareString .= $column.' = :'.$column.',';
            $valueString[$column] = $array[$column];
        }
        $sql = 'UPDATE '. $this->tableName. ' SET '. rtrim($prepareString, ','). ' WHERE id='.$id;
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($valueString);
    }

    public function save(array $array) {

        foreach ($array as $key => $val) {
            $keys[] = $key;
            $values[] = ':'.$key;
            $exec[$key] = $val;
        }
        $sql = 'INSERT INTO '. $this->tableName.
        ' ('. implode(',', $keys). ') VALUES ('. implode(',', $values). ')';
        
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($exec);
    }

    public function deleteById($rowId) {
        
        $sql = 'DELETE FROM '. $this->tableName. ' WHERE id = :id';
        $stmt = $this->dbc->prepare($sql);
        $result = $stmt->execute(['id' => $rowId]);
        return $result;
    }

    private function selectQuery($column='', $value='') {

        $sql = 'SELECT * FROM '. $this->tableName;
        $exec = [];
        if($column && $value) {
            $sql .= ' WHERE '. $column.' = :'.$column;
            $exec[$column] = $value;
        }
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($exec);
        return $stmt;
    }

    // for positional placeholders
    private function valuesBinder($stmt, $values) {
        $position = 1;
        foreach ($values as $value) {
            $stmt->bindValue($position, $value);
            $position++;
        }
    }
}