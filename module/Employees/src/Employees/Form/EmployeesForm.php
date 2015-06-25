<?php
namespace Employees\Form;

 use Zend\Form\Form;

 class EmployeesForm extends Form
 { 
     public $jobs;
     public $departments;
     public $employees;
     public function __construct($jobs,$departments,$employees)
     {
         $this->jobs=$jobs;
         $this->departments=$departments;
         $this->employees=$employees;
         // we want to ignore the name passed
         parent::__construct('employees');

         $this->add(array(
             'name' => 'employee_id',         
             'type' => 'Zend\Form\Element\Hidden',
             'options' => array(
                 'label' => 'employee_id',
             ),
             'attributes' => array(
                'class' => 'form-control'
             ),
         ));
         $this->add(array(
             'name' => 'first_name',
             'type' => 'Text',
             'required' => TRUE,
             'options' => array(
                 'label' => 'Primeiro Nome',
             ),
             'attributes' => array(
                'class' => 'form-control',
                 'placeholder' => 'Digite o primeiro nome',
             ),
         ));
         $this->add(array(
             'name' => 'last_name',
             'type' => 'Text',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Ultimo Nome',
             ),
             'attributes' => array(
                'class' => 'form-control',
                 'placeholder' => 'Digite o ultimo nome',
             ),
         ));
         $this->add(array(
             'name' => 'email',
             'type' => 'Email',
             'options' => array(
                 'label' => 'Email',
             ),
             'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Digite um email válido',
             ),
         ));
         $this->add(array(
             'name' => 'phone_number',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Telefone',
             ),
             'attributes' => array(
                'class' => 'form-control',
                 'placeholder' => 'Digite o telefone',
             ),
         ));
         
        
         $this->add(array(
             'name' => 'salary',
             'type' => 'Number',
             'options' => array(
                 'label' => 'Salario',
             ),
             'attributes' => array(
                'class' => 'form-control',
                 'placeholder' => 'Digite o salário',
             ),
         ));
         
          $this->add(array(
             'name' => 'commission_pct',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Comissão',
             ),
              'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Digite o percentual de Comissão',
             ),
         ));
          
         $this->add([
            'name' => 'job_id',
            'type' => 'Select',
            'options' => array(
                'label' => 'Cargo',
                'empty_option' => 'Selecione um cargo',
                'value_options' => $this->getOptionsForSelect(),
            ),
            'attributes' => array(
                'class' => 'form-control'
             ),
            
        ]);
         
          $this->add([
            'name' => 'department_id',
            'type' => 'Select',
            'options' => [
                'label' => 'Departamento',
                'empty_option' => 'Selecione um Departamento',
                'value_options' => $this->getOptionsDepartmentsSelect(),
            ],
            'attributes' => array(
               'class' => 'form-control'
            ),
        ]);
          
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
     public function getOptionsForSelect()
    {
        $selectData = array();
        foreach ($this->jobs as $job){        
            $selectData[$job->job_id] = $job->job_title;
        }
        
        return $selectData;
    }
    public function getOptionsDepartmentsSelect()
    {
        $selectData = array();
        foreach ($this->departments as $department){        
            $selectData[$department->department_id] = $department->department_name;
        }
        
        return $selectData;
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
 }