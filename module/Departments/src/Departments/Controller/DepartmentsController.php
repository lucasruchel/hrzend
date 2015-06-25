<?php

namespace Departments\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
 use Departments\Model\Departments;          // <-- Add this import
 use Departments\Form\DepartmentsForm;

class DepartmentsController extends AbstractActionController
{
 protected $departmentsTable;
 protected $employeesTable;
 protected $locationsTable;
 
 
    public function getLocationsTable(){
        if (!$this->locationsTable){
            $sm =  $this->getServiceLocator();
            $this->locationsTable = $sm->get('Locations\Model\LocationsTable');
        }
        
        return $this->locationsTable;
    }
    public function getEmployeesTable(){
        if (!$this->employeesTable){
            $sm =  $this->getServiceLocator();
            $this->employeesTable = $sm->get('Employees\Model\EmployeesTable');
        }
        
        return $this->employeesTable;
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
        $paginator = $this->getDepartmentsTable()->fetchAll(true);
     
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     
        $paginator->setItemCountPerPage(10);
        return new ViewModel(
                array(
                    'departments' => $paginator,            
                )
            );
        }

    public function deleteAction()
     {
        
         $id = (int) $this->params()->fromRoute('id', 0);
        
         if (!$id) {
             return $this->redirect()->toRoute('departments');
         }
         $request = $this->getRequest();
          
         
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
            
             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getDepartmentsTable()->deleteDepartments($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('departments');
         }

         return array(
             'id'    => $id,
             'departments' => $this->getDepartmentsTable()->getDepartments($id)
         );
     }
     
     
    public function addAction()
     {
        $employees =$this->getEmployeesTable()->fetchAll();
        $locations =$this->getLocationsTable()->fetchAll();
        $subDepartments =$this->getDepartmentsTable()->fetchAll();
       
         $form = new DepartmentsForm($employees,$locations,$subDepartments);//,$locations);
         
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $departments = new Departments();
             $form->setInputFilter($departments->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $departments->exchangeArray($form->getData());
                 $this->getDepartmentsTable()->saveDepartments($departments);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('departments');
             }
         }
         return array('form' => $form);
     }
    
     public function editAction()     
     {
        
         $id = (int)$this->params()->fromRoute('id', 0);
         
         if (!$id) {
             return $this->redirect()->toRoute('departments', array(
                 'action' => 'add'
             ));
         }
         try { 
             $departments = $this->getDepartmentsTable()->getDepartments($id);   
         }
         catch (\Exception $ex) {   
             return $this->redirect()->toRoute('departments', array(
                 'action' => 'edit'
             ));
         }
        
        $employees = $this->getEmployeesTable()->fetchAll();
        $locations = $this->getLocationsTable()->fetchAll();
        $subDepartments =$this->getDepartmentsTable()->fetchAll();      
        
         $form = new DepartmentsForm($employees,$locations,$subDepartments);  
         $form->bind($departments);
         $form->get('submit')->setAttribute('value', 'Editar');

         $request = $this->getRequest();
         
         if ($request->isPost()) {
             
             $form->setInputFilter($departments->getInputFilter());
             $form->setData($request->getPost());            
             if ($form->isValid()) {
                 $this->getDepartmentsTable()->updateDepartments($departments);

                 // Redirect to list of employees
                 return $this->redirect()->toRoute('departments');
             }
         }
         
         return array(
             'department_id' => $id,
             'form' => $form,
         );
     }   
    

}