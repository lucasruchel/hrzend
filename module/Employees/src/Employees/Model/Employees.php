<?php
namespace Employees\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;



class Employees implements InputFilterAwareInterface{
    public $employee_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $hire_date;
    public $job_id;
    public $salary;
    public $comission_pct;
    public $manager_id;
    public $department_id;
    protected $inputFilter;  
    
    public function exchangeArray($data){
        $this->employee_id = (!empty($data['employee_id'])) ? $data['employee_id'] : null;
        $this->first_name = (!empty($data['first_name'])) ? $data['first_name'] : null;
        $this->last_name = (!empty($data['last_name'])) ? $data['last_name'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->phone_number = (!empty($data['phone_number'])) ? $data['phone_number'] : null;
        $this->hire_date = (!empty($data['hire_date'])) ? $data['hire_date'] : null;
        $this->job_id = (!empty($data['job_id'])) ? $data['job_id'] : null;
        $this->salary = (!empty($data['salary'])) ? $data['salary'] : null;
        $this->commission_pct = (!empty($data['commission_pct'])) ? $data['commission_pct'] : null;
        $this->manager_id = (!empty($data['manager_id'])) ? $data['manager_id'] : null;
        $this->department_id = (!empty($data['department_id'])) ? $data['department_id'] : null;  
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
     
    public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();                                   

             $inputFilter->add(array(
                 'name'     => 'email',
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

             
             
              $inputFilter->add(array(
                 'name'     => 'first_name',
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
              
             $inputFilter->add(array(
                 'name'     => 'last_name',
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
             $inputFilter->add(array(
                 'name'     => 'salary',
                 'required' => true,
                 'validators' => array(
                     array(
                         'name'    => 'Float',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 0,
                         ),
                     ),
                 ),
             ));
             $inputFilter->add(array(
                 'name'     => 'commission_pct',
                 'required' => true,
                  'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'Between',
                         'options' => array(
                             'min'      => 0,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
             $inputFilter->add(array(
                 'name'     => 'manager_id',
                 'required' => false,
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
     
     
 }