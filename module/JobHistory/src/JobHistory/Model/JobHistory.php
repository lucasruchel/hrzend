<?php

namespace JobHistory\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class JobHistory{
    public $job_name;
    public $employee_id;
    public $employee_name;
    public $start_date;
    public $end_date;
    public $department_name;
    
    public function exchangeArray($data){
          
        $this->job_name = (!empty($data['job_name'])) ? $data['job_name'] : null;
        $this->employee_id = (!empty($data['employee_id'])) ? $data['employee_id'] : null;
        $this->employee_name = (!empty($data['employee_name'])) ? $data['employee_name'] : null;
        $this->start_date = (!empty($data['start_date'])) ? $data['start_date'] : null;
        $this->end_date = (!empty($data['end_date'])) ? $data['end_date'] : null;
        $this->department_name = (!empty($data['department_name'])) ? $data['department_name'] : null;
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

             $inputFilter->add(array(
                 'name'     => 'job_id',
                 'required' => false,
                 'filters'  => array(
                   array('name' => 'Int'),
                 ),
             ));
             
             
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
