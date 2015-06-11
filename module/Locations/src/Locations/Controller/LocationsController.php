<?php

namespace Locations\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LocationsController extends AbstractActionController
{
    protected $locationsTable;

    public function getLocationsTable(){
        if (!$this->locationsTable){
            $sm = $this->getServiceLocator();
            
            $this->locationsTable = $sm->get('Locations\Model\LocationsTable');
        }
        return $this->locationsTable;
    }

    public function indexAction()
    {
        return new ViewModel(
                array(
                    'locations' => $this->getLocationsTable()->fetchAll(),
                )
            );
    }


}

