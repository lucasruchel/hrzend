<?php

namespace Employees\Model;

use Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ObjectProperty;

class EmployeesTable {

    
    protected $tableGateway;
    public $dbAdapter;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getEmployeeAll($id){
     
//        $select = new Select;
//        $select->from('selectemployees');
//            ->join('jobs', 'jobs.job_id = employees.job_id')
//            ->join('departments', 'departments.department_id = employees.department_id');
        
        
        
        $select = new Select;
        $select->from(array('e' => $this->tableGateway->getTable()))
               ->columns(array('*','manager' => new Expression('concat(m.first_name,\' \',m.last_name)')))
               ->join(array('m'=>'employees'), 'e.manager_id=m.employee_id', array(),'left')
               ->join(array('j' => 'jobs'),'j.job_id=e.job_id',array('job_title'))
               ->join(array('d' => 'departments'),'d.department_id=e.department_id',array('department_name'),'left')
               ->where(array('e.employee_id' => (int) $id));
        
            
        
        $resultSet = $this->tableGateway->selectWith($select);
        
       
       
        
        return $resultSet;
    }
    
    public function fetchAll($paginated=false){
        
        $select = $this->tableGateway->getSql()->select();
        
        
        
        $select->columns(array('employee_id',
                               'full_name' => new Expression('concat(first_name,\' \',last_name)')))
                ->join(array('d' => 'departments'),'d.department_id = employees.department_id',array('department_name'))
                ->join(array('j' => 'jobs'),'j.job_id=employees.job_id',array('job_title'))
                ->order('employees.employee_id');
                
                
        
        
        
        //Para paginação
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


    public function getEmployees($id){
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('employee_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new Exception("Could not find row $id");
         }
         return $row;
     }
     
    public function saveEmployees($employees){  
    //$insert = new Insert('employees');
    
        $data = (array(   
        'employee_id'   =>0,
        'first_name'    =>$employees->first_name,
        'last_name'     =>$employees->last_name,
        'email'         =>$employees->email,
        'job_id'        =>$employees->job_id,
        'hire_date'     =>date('Y-m-d H:i:s'),
        'phone_number'  =>$employees->phone_number,
        'manager_id'    =>$employees->manager_id,
        'salary'        =>$employees->salary,
        'commission_pct'=>$employees->commission_pct/100,
        'department_id' =>$employees->department_id    
        ));
        
        
        $select = $this->tableGateway->getSql()->select();
            
             $select->columns(array(
                'maxId' => new Expression('MAX(employee_id)')
            ));
            $rowset = $this->tableGateway->selectWith($select);
            $row = $rowset->current();
            if (!$row) {
                throw new Exception("Could not retrieve max Employee Id");
            }
            
            $id = ((int) $row->maxId)+1;
            $data['employee_id'] = $id;
        
            
        $this->tableGateway->insert($data); 
       
    }
    
    public function updateEmployees($employees){  
        $id=(int) $employees->employee_id;
        
        $data = (array(          
        'first_name'    =>$employees->first_name,
        'last_name'     =>$employees->last_name,
        'email'         =>$employees->email,
        'job_id'        =>$employees->job_id,
        //'hire_date'     =>date('Y-m-d H:i:s'),
        'phone_number'  =>$employees->phone_number,
        'manager_id'    =>$employees->manager_id,
        'salary'        =>$employees->salary,
        'commission_pct'=>$employees->commission_pct/100,
        'department_id' =>$employees->department_id    
        ));
        
        try {
            $this->tableGateway->update($data,array('employee_id'=>$id));  
        } catch (\Exception $exc) {
            throw new \Exception('Erro ao alterar funcionário, possivel o cargo ja foi alterado ou cadastrado hoje. Não é possível alterar sucessivamente de cargo o mesmo funcionario no mesmo dia');
        }



        
        
        
    }
    
     public function deleteEmployees($id){
          $this->tableGateway->delete(array('employee_id' => (int) $id));
     }
}
