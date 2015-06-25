<?php
namespace JobHistory\Form;

 use Zend\Form\Form;

 class JobHistoryForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('jobHistory');

         $this->add(array(
             'name' => 'employee_id',
             'type' => 'Text',
             'attributes' => array(
                 'placeholder' => 'id',
                 'class' => 'form-control'
                 ),
         ));
         $this->add(array(
             'name' => 'employee_name',
             'type' => 'Text',
             'attributes' => array(
                 'placeholder' => 'Empregado',
                 'class' => 'form-control'
            ),
         ));              
         $this->add(array(
             'name' => 'job_name',
             'type' => 'Text',
             'attributes' => array(
                 'placeholder' => 'Cargo',
                 'class' => 'form-control'
            ),
         ));
         $this->add(array(
             'name' => 'begin_date',
             'type' => 'Text',
             'attributes' => array(
                 'placeholder' => 'Data de Inicio',
                 'class' => 'form-control',
                 'disabled' => true,
                 
            ),
         ));
         $this->add(array(
             'name' => 'end_date',
             'type' => 'Text',
             'attributes' => array(
                 'placeholder' => 'Data de término',
                 'class' => 'form-control',
                 'disabled' => true,   
            ),
            
         ));
         $this->add(array(
             'name' => 'department_name',
             'type' => 'Text',
             'attributes' => array(
                 'placeholder' => 'Departamento',
                 'class' => 'form-control',
                 
            ),
         ));
     }
 }