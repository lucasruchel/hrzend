<?php

namespace Countries\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class CountriesTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $select = new Select;
        $select->from('countries')
            ->join('regions', 'countries.region_id = regions.region_id');

        
        $resultSet = $this->tableGateway->selectWith($select);
        

        
        return $resultSet;
    }
}

