<?php

namespace Departments\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Expression;

class DepartmentsTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $select = new Select;
        $select->from('departments')
            ->join('locations', 'departments.location_id = locations.location_id',array('*'),'left')
            ->join('employees', 'employees.employee_id = departments.manager_id',array('first_name','last_name'),'left');

        
        $resultSet = $this->tableGateway->selectWith($select);
       
        return $resultSet;
    }
    
    public function getDepartments($id){
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('department_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }
    
    public function saveDepartments($departments){  
    //$insert = new Insert('employees');
        $data = (array(   
        'department_id'       =>$departments->department_id,
        'department_name'    =>$departments->department_name,
        'manager_id'   =>$departments->manager_id, 
        'location_id'  =>$departments->location_id,
        )); 
        
        $select = $this->tableGateway->getSql()->select();
            
             $select->columns(array(
                'maxId' => new Expression('MAX(department_id)')
            ));
            $rowset = $this->tableGateway->selectWith($select);
            $row = $rowset->current();
            if (!$row) {
                throw new \Exception("Could not retrieve max Employee Id");
            }
            
            $id = ((int) $row->maxId)+1;
            $data['department_id'] = $id;
            
        $this->tableGateway->insert($data);  
    }
    
    public function updateDepartments($departments){  
        $id=$departments->department_id;
        
        $data = (array(          
            'department_name' => $departments->department_name,
            'manager_id' => $departments->manager_id,
            'location_id' => $departments->location_id,
       
        ));
        
        $this->tableGateway->update($data,array('department_id'=>$id));  
    }
    public function deleteDepartments($id){
          $this->tableGateway->delete(array('department_id' => (int) $id));
     }
}

