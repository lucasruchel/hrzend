<?php

namespace Locations\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class LocationsTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $select = new Select;
        $select->from($this->tableGateway->getTable())
            ->join('countries', 'locations.country_id = countries.country_id');

        
        $resultSet = $this->tableGateway->selectWith($select);
        

        
        return $resultSet;
    }
}
