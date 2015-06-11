<?php

namespace Regions\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegionsController extends AbstractActionController
{
    protected $regionsTable;
    
    public function getRegionsTable(){
        if (!$this->regionsTable){
            $sm = $this->getServiceLocator();
            
            $this->regionsTable = $sm->get('Regions\Model\RegionsTable');
        }
        return $this->regionsTable;
    }


    public function indexAction()
    {
        
        
        return new ViewModel(
                array(
                    'regions' => $this->getRegionsTable()->fetchAll(),
                )
            );
    }


}

