<?php

namespace Employees\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Employees\Model\Employees;
use Employees\Form\EmployeesForm; 


class EmployeesController extends AbstractActionController
{
    protected $employeesTable;
    protected $jobsTable;
    protected $departmentsTable;
    protected $managerTable;


    public function getEmployeesTable(){
        if (!$this->employeesTable){
            $sm =  $this->getServiceLocator();
            $this->employeesTable = $sm->get('Employees\Model\EmployeesTable');
        }
        
        return $this->employeesTable;
    }

    public function getJobsTable(){
        if (!$this->jobsTable){
            $sm =  $this->getServiceLocator();
            $this->jobsTable = $sm->get('Jobs\Model\JobsTable');
        }
        
        return $this->jobsTable;
    }

    public function getDepartmentsTable(){
        if (!$this->departmentsTable){
            $sm =  $this->getServiceLocator();
            $this->departmentsTable = $sm->get('Departments\Model\DepartmentsTable');
        }
        
        return $this->departmentsTable;
    }

    public function indexAction()
    {
        return new ViewModel(
                array(
                    'employees' => $this->getEmployeesTable()->fetchAll(),
                )
            );
    }

    public function editAction()     
     {
        
         $id = (int)$this->params()->fromRoute('id', 0);
         
         if (!$id) {
             return $this->redirect()->toRoute('employees', array(
                 'action' => 'add'
             ));
         }
         
         try { 
             $employee = $this->getEmployeesTable()->getEmployees($id);   
         }
         catch (\Exception $ex) {   
             return $this->redirect()->toRoute('employees', array(
                 'action' => 'edit'
             ));
         }
        //Para o select *****
        $jobs=$this->getJobsTable()->fetchAll();
        $departments=$this->getDepartmentsTable()->fetchAll();
        $employees = $this->getEmployeesTable()->fetchAll();
        //**
        
        
         $form = new EmployeesForm($jobs,$departments,$employees);  
         
         //Associa os dados do formulario
         $form->bind($employee);
         $form->get('submit')->setAttribute('value', 'Editar');

         $request = $this->getRequest();
           
         if ($request->isPost()) {
             
             $form->setInputFilter($employee->getInputFilter());
             $form->setData($request->getPost());            
             if ($form->isValid()) {
                 $this->getEmployeesTable()->updateEmployees($employee);
                 
                 
                 return $this->redirect()->toRoute('employees');
             }
         }
         
         return array(
             'employee_id' => $id,
             'form' => $form,
         );
     }   

    public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('employees');
         }
         
         $request = $this->getRequest();
        
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             
             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getEmployeesTable()->deleteEmployees($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('employees');
         }

         return array(
             'id'    => $id,
             'employees' => $this->getEmployeesTable()->getEmployees($id)
         );
     }
     
     
    public function insertAction()
    {
        return new ViewModel(
        array(
                'employees' => $this->getEmployeesTable()->fetchAll(),
                'departments' => $this->getEmployeesTable()->fetchAll(),
                'jobs' => $this->getEmployeesTable()->fetchAll(),
               
            ));
    }
    public function addAction()
     {
        $jobs=$this->getJobsTable()->fetchAll();
        $departments=$this->getDepartmentsTable()->fetchAll();
        $employees =$this->getEmployeesTable()->fetchAll();
                
        $form = new EmployeesForm($jobs,$departments,$employees);       
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
        
         if ($request->isPost()) {
             $employee = new Employees();
             $form->setInputFilter($employee->getInputFilter());
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
                 
                 $employee->exchangeArray($form->getData());
                 $this->getEmployeesTable()->saveEmployees($employee);

                 // Redirect to list of employees
                 return $this->redirect()->toRoute('employees');
             }
         }
         return array('form' => $form);
     }
}

