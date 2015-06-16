<?php

namespace Employees\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EmployeesController extends AbstractActionController
{
    protected $employeesTable;


    public function getEmployeesTable()
    {
        if (!$this->employeesTable){
            $sm = $this->getServiceLocator();
            $this->employeesTable = $sm->get('Employees\Model\EmployeesTable');
        }
        
        return $this->employeesTable;
    }

    public function indexAction()
    {
        return new ViewModel(
                    array(
                        'employees' => $this->getEmployeesTable()->fetchAll(),
                    )
                
                );
    }


}

