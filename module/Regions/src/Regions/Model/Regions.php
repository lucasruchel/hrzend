<?php

namespace Regions\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

class Regions implements InputFilterAwareInterface{
    public $region_id;
    public $region_name;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->region_id = (!empty($data['region_id'])) ? $data['region_id'] : null;
        $this->region_name = (!empty($data['region_name'])) ? $data['region_name'] : null;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception('Não Usado');
    
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {    
            $inputFilter = new InputFilter();

             
            $inputFilter->add(array(
                 'name'     => 'region_name',
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
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
    
}

