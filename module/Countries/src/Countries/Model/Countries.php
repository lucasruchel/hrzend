<?php

namespace Countries\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Countries implements InputFilterAwareInterface{
    public $country_id;
    public $country_name;
    public $region_id;
    protected $inputFilter;
    


    public function exchangeArray($data){
        $this->country_id = (!empty($data['country_id'])) ? $data['country_id'] : null;
        $this->country_name = (!empty($data['country_name'])) ? $data['country_name'] : null;
        $this->region_id = (!empty($data['region_id'])) ? $data['region_id'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    public function getInputFilter() {
        if (!$this->inputFilter) {    
            $inputFilter = new InputFilter();

             
            $inputFilter->add(array(
                 'name'     => 'country_id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 2,
                         ),
                     ),
                 ),
             ));
            $inputFilter->add(array(
                 'name'     => 'country_name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
            $inputFilter->add(array(
                 'name'     => 'country_name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
            
            $inputFilter->add(array(
                 'name'     => 'region_id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                     
                 ),
                 
             ));
             $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
        throw new Exception('Não Usado');
    }

}
