<?php

namespace Locations\Model;

use Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ObjectProperty;

class LocationsTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($paginated=false){
        $select = new Select;
        $select->from($this->tableGateway->getTable())
            ->join('countries', 'locations.country_id = countries.country_id')
            ->order('location_id');
        
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
    public function saveLocation(Locations $location){
        $id = (int) $location->location_id;
        
        $data = array(
            'street_address' => $location->street_address,
            'postal_code' => $location->postal_code,
            'city' => $location->city,
            'state_province' => $location->state_province,
            'country_id' => $location->country_id,
        );
        
        if($id == 0)
        {
            $select = $this->tableGateway->getSql()->select();
            
             $select->columns(array(
                'maxId' => new Expression('MAX(location_id)')
            ));
            $rowset = $this->tableGateway->selectWith($select);
            $row = $rowset->current();
            if (!$row) {
                throw new Exception("Could not retrieve max Location Id");
            }
            
            $id = ((int) $row->maxId)+1;
            
            $data['location_id'] = $id;
            
            $this->tableGateway->insert($data);
            
        }
        else
        {
            $id = (int) $location->location_id;
            
            $this->tableGateway->update($data,array('location_id' => $id));
        }
        
    }
    public function getLocation($id){
        $rowset = $this->tableGateway->select(array('location_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row;
    }
    public function deleteLocation($id){
        $this->tableGateway->delete(array('location_id' => $id));
    }
}
