<?php

namespace Countries\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CountriesController extends AbstractActionController
{
    protected $countriesTable;
    
    public function getCountriesTable(){
        if (!$this->countriesTable){
            $sm =  $this->getServiceLocator();
            $this->countriesTable = $sm->get('Countries\Model\CountriesTable');
        }
        
        return $this->countriesTable;
    }

        public function indexAction()
    {
        return new ViewModel(
                array(
                    'countries' => $this->getCountriesTable()->fetchAll(),
                )
            );
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function removeAction()
    {
        return new ViewModel();
    }


}

