<?php

namespace Departments\Model;

use Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ObjectProperty;

class DepartmentsTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($paginated=false){
        $select = new Select;
        $select->from(array('de' => $this->tableGateway->getTable()))
            ->join('locations', 'de.location_id = locations.location_id',array('*'),'left')
            ->join(array('d'=>'departments'), 'de.sub_department = d.department_id',array('sub_department_name'=>'department_name'),'left')
            ->join('employees', 'employees.employee_id = de.manager_id',array('first_name','last_name'),'left')
            ->order(array('department_id'));
    
    
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
    
    public function getDepartments($id){
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('department_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new Exception("Could not find row $id");
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
        'sub_department'=>$departments->sub_department,
        )); 
        
        $select = $this->tableGateway->getSql()->select();
            
             $select->columns(array(
                'maxId' => new Expression('MAX(department_id)')
            ));
            $rowset = $this->tableGateway->selectWith($select);
            $row = $rowset->current();
            if (!$row) {
                throw new Exception("Could not retrieve max Employee Id");
            }
            
            $id = ((int) $row->maxId)+1;
            $data['department_id'] = $id;
        
        try{   
            $this->tableGateway->insert($data);  
        }catch (Exception $e){
           echo 'exceção: ', $e->getMessage(), "\n"; 
        }
    }
    
    public function updateDepartments($departments){  
        $id=$departments->department_id;
       
        $data = (array(          
            'department_name' => $departments->department_name,
            'manager_id' => $departments->manager_id,
            'location_id' => $departments->location_id,
            'sub_department'=>$departments->sub_department,
        ));
        try{
            $this->tableGateway->update($data,array('department_id'=>$id)); 
        }catch (Exception $e){
           echo 'exceção: ', $e->getMessage(), "\n"; 
        }
    }
    public function deleteDepartments($id){
        try{
          $this->tableGateway->delete(array('department_id' => (int) $id));
          
        }catch (Exception $e){
            echo 'exceção: ', $e->getMessage(), "\n"; 
        }
     }
}

