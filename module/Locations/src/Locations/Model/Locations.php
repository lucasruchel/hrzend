<?php

namespace Locations\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Locations{
    public $location_id;
    public $street_address;
    public $postal_code;
    public $city;
    public $country_id;
    public $state_province;
    public $inputFilter;
    
    public function exchangeArray($data){
        $this->location_id = (!empty($data['location_id']))  ? $data['location_id'] : null;
        $this->street_address = (!empty($data['street_address'])) ? $data['street_address'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
        $this->country_id = (!empty($data['country_id'])) ? $data['country_id'] : null;
        $this->postal_code = (!empty($data['postal_code'])) ? $data['postal_code'] : null;
        $this->state_province = (!empty($data['state_province'])) ? $data['state_province'] : null;
    }
    public function getArrayCopy(){
        return get_object_vars($this);
    }
    public function getInputFilter() {
            if (!$this->inputFilter) {    
                $inputFilter = new InputFilter();

             
            $inputFilter->add(array(
                 'name'     => 'location_id',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
            $inputFilter->add(array(
                 'name'     => 'street_address',
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
                             'min'      => 5,
                             'max'      => 40,
                         ),
                     ),
                 ),
             ));
            $inputFilter->add(array(
                 'name'     => 'postal_code',
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
                             'max'      => 12,
                         ),
                     ),
                 ),
             ));
            $inputFilter->add(array(
                 'name'     => 'city',
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
                             'max'      => 30,
                         ),
                     ),
                 ),
             ));
            $inputFilter->add(array(
                 'name'     => 'state_province',
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
                             'max'      => 25,
                         ),
                     ),
                 ),
             ));
            
            $inputFilter->add(array(
                 'name'     => 'state_province',
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
                             'max'      => 25,
                         ),
                     ),
                 ),
             ));
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
             $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception('Not used');
    }

}
