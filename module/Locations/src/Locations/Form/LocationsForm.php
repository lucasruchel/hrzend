<?php

namespace Locations\Form;

use Zend\Form\Form;

class LocationsForm extends Form{
    protected $countriesTable;


    public function __construct($countriesTable = null,$name = null) {
        parent::__construct($name);
        
        $this->countriesTable = $countriesTable;
        
        $this->add(array(
                'type' => 'Zend\Form\Element\Hidden',
                'name' => 'location_id',
                'attributes' => array(
                    'value' => 0,
                    'placeholder' => 'Digite o ID do novo Endereço',
                    'required' => 'required',
                    'class' => 'form-control',
                ),
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Text',
                'name' => 'street_address',
                'options' => array(
                    'label' => 'Nome da rua'
                ),
                'attributes' => array(
                    'placeholder' => 'Digite o endereço da rua',
                    
                    'class' => 'form-control'
                ),
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Text',
                'name' => 'city',
                'options' => array(
                    'label' => 'Nome da cidade'
                ),
                'attributes' => array(
                    'placeholder' => 'Digite o nome da cidade',
                    'required' => 'required',
                    'class' => 'form-control'
                ),
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Text',
                'name' => 'state_province',
                'required' => false,
                'options' => array(
                    'label' => 'Nome do estado/provincia'
                ),
                'attributes' => array(
                    'placeholder' => 'Digite o nome do estado/provincia',
                    
                    'class' => 'form-control',
                ),
        ));
        $this->add(array(
                'type' => '\Zend\Form\Element\Text',
                'name' => 'postal_code',
                'options' => array(
                    'label' => 'Código Postal'
                ),
                'attributes' => array(
                    'placeholder' => 'Digite o código postal',
                    
                    'class' => 'form-control'
                ),
        ));
        
        
        
        $this->add(array(
                'type' => '\Zend\Form\Element\Select',
                'name' => 'country_id',
                'attributes' => array(
                    'class' => 'form-control',
                    
                ),
                'options' => array(
                   'label' => 'Selecione a região',
                   
                   'empty_option' => 'Por favor escolha um país',
                   'value_options' => $this->getCountriesOptions(),
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
    
    public function getCountriesOptions(){
        $options = array();
        foreach ($this->countriesTable as $country){
            $options[$country->country_id] = $country->country_name;
        }
        return $options;
    }
}


