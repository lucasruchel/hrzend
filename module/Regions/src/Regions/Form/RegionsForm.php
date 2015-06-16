<?php

namespace Regions\Form;

use Zend\Form\Form;

class RegionsForm extends Form{
    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Hidden',
                'name' => 'region_id',
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Text',
                'name' => 'region_name',
                'options' => array(
                    'label' => 'Nome'
                ),
                'attributes' => array(
                    'placeholder' => 'Digite o nome da região',
                    'required' => 'required',
                    'class' => 'form-control'
                ),
        ));
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Submit',
                'name' => 'submit',
                'attributes' => array(
                    'value' => 'Adicionar',
                    'id' => 'submitButton',
                    'class' => 'btn btn-submit',
                ),
        ));
    }
}
