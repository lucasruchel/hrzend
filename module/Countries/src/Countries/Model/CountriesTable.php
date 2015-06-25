<?php

namespace Countries\Model;

use Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ObjectProperty;

class CountriesTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($paginated=null){
        $select = $this->tableGateway->getSql()->select();
        $select->join('regions', 'countries.region_id = regions.region_id')
               ->order('country_id');

         if($paginated){
            
            
            $resultSetPrototype = new HydratingResultSet();
            $resultSetPrototype->setHydrator(new ObjectProperty());
            
             $paginatorAdapter = new DbSelect(
                 
                 $select,
                 
                 $this->tableGateway->getAdapter(),
                 
                 $resultSetPrototype
             );
             
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
        }
        
        $resultSet = $this->tableGateway->selectWith($select);
        
        return $resultSet;
    }
    public function saveCountry(Countries $country){
        $data = array(
            'country_id' => $country->country_id,
            'country_name' => $country->country_name,
            'region_id' => $country->region_id,
        );
        
        $this->tableGateway->insert($data);
    }
    public function getCountry($id){
        $rowset = $this->tableGateway->select(array('country_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row;
    }
    public function updateCountry(Countries $country){
        $data = array();
        
        $data['region_id'] = $country->region_id;
        $data['country_name'] = $country->country_name;
        
        $this->tableGateway->update($data, array('country_id' => $country->country_id));
                
    }
     public function deleteCountry($id)
     {
         $this->tableGateway->delete(array('country_id' => $id));
     }
}

