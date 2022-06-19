<?php
namespace Cms\core;
use Cms\core\Entity;

class Searcher extends Entity {

    private $input;

    public function __construct($dbc, $table, $input) {
        parent::__construct($dbc, $table);
        $this->input = $input;
    }

    public function inputMatch() {

        $dbObjs = $this->findAll();
        $columns = $this->getColumns();

        foreach($dbObjs as $obj) {
            foreach ($columns as $column) {
                if(strpos(strtolower($obj->$column), strtolower($this->input)) !== false) {
                    $matchingObjs[] = $obj;
                    break;
                }
            }
        }
        return $matchingObjs ?? false;
    }
}