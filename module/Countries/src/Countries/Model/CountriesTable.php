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
        $select = $this->tableGateway->getSql()->select();
        $select->join('regions', 'countries.region_id = regions.region_id');

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
            throw new \Exception("Could not find row $id");
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

