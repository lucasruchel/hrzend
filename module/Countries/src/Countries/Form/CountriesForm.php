<?php

namespace Countries\Form;

use Zend\Form\Form;

class CountriesForm extends Form{
    protected $regionsTable;


    public function __construct($regionsTable = null,$name = null) {
        parent::__construct($name);
        
        $this->regionsTable = $regionsTable;
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Text',
                'name' => 'country_id',
                'attributes' => array(
                    'placeholder' => 'Digite o ID do novo país',
                    'required' => 'required',
                    'class' => 'form-control',
                ),
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Text',
                'name' => 'country_name',
                'options' => array(
                    'label' => 'Nome'
                ),
                'attributes' => array(
                    'placeholder' => 'Digite o nome do país',
                    'required' => 'required',
                    'class' => 'form-control'
                ),
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Select',
                'name' => 'region_id',
                'attributes' => array(
                    'class' => 'form-control',
                    
                ),
                'options' => array(
                   'label' => 'Selecione a região',
                   
                   'empty_option' => 'Por favor escolha uma região',
                   'value_options' => $this->getRegionsOptions(),
                )
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
    
    public function getRegionsOptions(){
        $options = array();
        foreach ($this->regionsTable as $region){
            $options[$region->region_id] = $region->region_name;
        }
        return $options;
    }
}
