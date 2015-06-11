<?php

namespace Job_history\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Job_HistoryController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

