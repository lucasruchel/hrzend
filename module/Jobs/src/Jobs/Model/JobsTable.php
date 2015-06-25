<?php

namespace Jobs\Model;

use Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ObjectProperty;

class JobsTable{

    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($paginated=false){
        $select = new Select;
        $select->from('jobs')
               ->order('job_id');

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
    public function getJobs($id){
         $id  = $id;
         $rowset = $this->tableGateway->select(array('job_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new Exception("Could not find row $id");
         }
         return $row;
     }
     public function saveJobs($jobs){  
    //$insert = new Insert('employees');
    
        $data = (array(   
        'job_id'       =>$jobs->job_id,
        'job_title'    =>$jobs->job_title,
        'min_salary'   =>$jobs->min_salary,
        'max_salary'   =>$jobs->max_salary,
          
        ));                        
        $this->tableGateway->insert($data);  
    }
    
     public function updateJobs($jobs){  
        $id=$jobs->job_id;
        
        $data = (array(          
        'job_title'     =>$jobs->job_title,
        'min_salary'    =>$jobs->min_salary,
        'max_salary'    =>$jobs->max_salary,
       
        ));
        
        $this->tableGateway->update($data,array('job_id'=>$id));  
    }
    
     public function deleteJobs($id){
        
          $this->tableGateway->delete(array('job_id' => $id));
     }
}

