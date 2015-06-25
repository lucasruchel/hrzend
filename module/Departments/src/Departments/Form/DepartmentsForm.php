<?php 
namespace Departments\Form;

 use Zend\Form\Form;

 class DepartmentsForm extends Form
 {
     public $employees;
     public $locations;
     public $departments;
    
     public function __construct($employees,$locations,$departments)
     {
         $this->employees=$employees;
         $this->locations= $locations;
         $this->departments= $departments;
         // we want to ignore the name passed
         parent::__construct('departments');

         $this->add(array(
             'name' => 'department_id',
             'type' => 'Hidden',
             'attributes' => array(
                 'class' => 'form-control'
             ),
         ));
         $this->add(array(
             'name' => 'department_name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Nome do Departamento',
             ),
             'attributes' => array(
                 'class' => 'form-control',
                 'placeholder' => 'Digite o nome do departamento',
             ),
         ));
        $this->add([
            'name' => 'manager_id',
            'type' => 'Select',
            'options' =>[
                'label' => 'Gerente',
                'empty_option' => 'Selecione um Gerente',
                'value_options' => $this->getOptionsManagerSelect(), 
            ],
            'attributes' => array(
                 'class' => 'form-control'
             ),
            
        ]);
        $this->add([
            'name' => 'location_id',
            'type' => 'Select',
            'options' =>[
                'label' => 'Local',
                'empty_option' => 'Selecione um local',
                'value_options' => $this->getOptionsLocationsSelect(), 
            ],
            'attributes' => array(
                 'class' => 'form-control'
             ),
            
        ]);
        $this->add([
            'name' => 'sub_department',
            'type' => 'Select',
            'options' =>[
                'label' => 'Departamento Chefe',
                'empty_option' => 'Selecione um Departamento',
                'value_options' => $this->getOptionsSubDepartmentSelect(), 
            ],
            'attributes' => array(
                 'class' => 'form-control'
             ),
        ]); 
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-submit'
             ),
         ));
     }
     
     public function getOptionsManagerSelect()
    {
        $selectData = array();       
        foreach ($this->employees as $employee){   
            $selectData[$employee->employee_id] = $employee->full_name;
        }
        //carrego mais ainda deu um erro
        //esse erro deve ser pera
        return $selectData;
    }
    public function getOptionsSubDepartmentSelect()
    {
        $selectData = array(); 
       
        foreach ($this->departments as $department){
            
        
            $selectData[$department->department_id] = $department->department_name;
        }
        
        //carrego mais ainda deu um erro
        //esse erro deve ser pera
        return $selectData;
    }
    public function getOptionsLocationsSelect()
    {
        $selectData = array();       
        
        
        
        foreach ($this->locations as $location){
            $selectData[$location->location_id] = $location->country_id.' : '.$location->street_address;
            
           
        }
        
        
        //carrego mais ainda deu um erro
        //esse erro deve ser pera
        return $selectData;
    }
 }

