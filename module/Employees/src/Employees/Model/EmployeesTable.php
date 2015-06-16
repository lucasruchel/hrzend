<?php

namespace Employees\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class EmployeesTable{
    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $select = new Select;
        $select->from($this->tableGateway->getTable());
            

        
        $resultSet = $this->tableGateway->selectWith($select);
        

        
        return $resultSet;
    }
}

