<?php
namespace Regions\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class RegionsTable{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll() {
        $select = new Select;
        $select->from($this->tableGateway->getTable());
               
        
        $resultSet = $this->tableGateway->selectWith($select);
        
        \Zend\Debug\Debug::dump($resultSet);
    
        $resultSet;
    }
}