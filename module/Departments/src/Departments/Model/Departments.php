<?php

namespace Departments\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Departments{
    public $department_id;
    public $department_name;
    public $manager_id;
    public $location_id;
    public $sub_department;
    public $inputFilter;
    
    public function exchangeArray($data){
        $this->department_id = (!empty($data['department_id'])) ? $data['department_id'] : null;
        $this->department_name = (!empty($data['department_name'])) ? $data['department_name'] : null;
        $this->manager_id = (!empty($data['manager_id'])) ? $data['manager_id'] : null;
        $this->location_id = (!empty($data['location_id'])) ? $data['location_id'] : null;
        $this->sub_department = (!empty($data['sub_department'])) ? $data['sub_department'] : null; 
    }
    public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

//             $inputFilter->add(array(
//                 'name'     => 'department_id',
//                 'type'     => 'hidden',
//                 'required' => true,
//                 'filters'  => array(
//                     array('name' => 'Int'),
//                 ),
//             ));

             $inputFilter->add(array(
                 'name'     => 'department_name',
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
                             'max'      => 30,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
