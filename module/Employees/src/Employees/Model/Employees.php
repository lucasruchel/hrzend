<?php
namespace Employees\Model;

class Employees{
    public $employee_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $hire_date;
    public $job_id;
    public $salary;
    public $commission_pct;
    public $manager_id;
    
    public function exchangeArray($data){
        
    }
}



