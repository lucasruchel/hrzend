<?php
namespace Jobs\Form;

 use Zend\Form\Form;

 class JobsForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('album');

         $this->add(array(
            'name' => 'job_id',
            'type' => 'Text',
            'options' => array(
                 'label' => 'ID do cargo',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Digite o ID do cargo',
             ),
         ));
         $this->add(array(
             'name' => 'job_title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Titulo do Cargo',
             ),
             'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Digite o título do cargo',
             ),
             
         ));
         $this->add(array(
             'name' => 'min_salary',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Sálario Máximo do Cargo',
             ),
             'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Digite o sálario Minino do Cargo',
             ),
         ));
         $this->add(array(
             'name' => 'max_salary',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Sálario Máximo do Cargo',
             ),
             'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Digite o o sálario Maximo do Cargo',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
             'attributes' => array(
                'class' => 'btn btn-submit',
                
             ),
         ));
     }
 }