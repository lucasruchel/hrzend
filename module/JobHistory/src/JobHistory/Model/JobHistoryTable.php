<?php

namespace JobHistory\Model;

use Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Debug\Debug;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ObjectProperty;

class JobHistoryTable{
    
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($paginated=null,$params){
        $select = new Select();
        $where = new Where();
                
        $select->from('selectcargosatuaispassados');
        
        if(!empty($params['employee_name'])){
            $where->addPredicate(new Expression('lower(concat(first_name,\' \',last_name)) like lower(?)', '%'.htmlspecialchars($params['employee_name']).'%' ));
        }
        if(!empty($params['job_name'])){
            $where->addPredicate(new Expression('lower(job_title) like lower(?)', '%'.htmlspecialchars($params['job_name']).'%' ));
        }
        if(!empty($params['employee_id'])){
            $employee_id = (int) $params['employee_id'];
            
            $where->addPredicate(new Expression('employee_id = ?', htmlspecialchars($employee_id)));
        }
        if(!empty($params['department_name'])){
            $where->addPredicate(new Expression('lower(department_name) like lower(?)', '%'.htmlspecialchars($params['department_name']).'%' ));
        }
        $select->where($where);
        
       //Debug::dump($select->getSqlString());
        
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
    
    public function getJobHistoryTable($id){
         $rowset = $this->tableGateway->select(array('job_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new Exception("Could not find row $id");
         }
         return $row;
     }
     
     public function getJobHistory($id){
        $rowset = $this->tableGateway->select(array('job_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row;
    }
}

