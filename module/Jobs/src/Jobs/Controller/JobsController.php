<?php

namespace Jobs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JobsController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

