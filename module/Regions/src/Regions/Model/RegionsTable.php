<?php
namespace Regions\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;


class RegionsTable{
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
    
    public function saveRegion(Regions $region){
        $data = array(
            'region_name' => $region->region_name,
        );
        
        if(!empty($region->region_id)){
            $id = (int) $region->region_id;
            
            $this->tableGateway->update($data,array('region_id' => $id));
        }
        else
        {
            $select = $this->tableGateway->getSql()->select();
            
             $select->columns(array(
                'maxId' => new Expression('MAX(region_id)')
            ));
            $rowset = $this->tableGateway->selectWith($select);
            $row = $rowset->current();
            if (!$row) {
                throw new \Exception("Could not retrieve max Regions Id");
            }
            
            $id = ((int) $row->maxId)+1;
            
            $data['region_id'] = $id;
            
            $this->tableGateway->insert($data);
            
        }
    }
    public function getRegions($id){
        $id  = (int) $id;
         
        $rowset = $this->tableGateway->select(array('region_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    public function deleteRegion($id)
     {
         $this->tableGateway->delete(array('region_id' => (int) $id));
     }
}
