<?php

namespace Employees\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EmployeesController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

