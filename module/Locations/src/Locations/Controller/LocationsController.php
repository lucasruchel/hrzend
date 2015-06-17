<?php

namespace Locations\Controller;


use Locations\Form\LocationsForm;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LocationsController extends AbstractActionController
{

    protected $locationsTable = null;

    protected $countriesTable = null;

    public function getLocationsTable()
    {
        if (!$this->locationsTable){
            $sm = $this->getServiceLocator();
            
            $this->locationsTable = $sm->get('Locations\Model\LocationsTable');
        }
        return $this->locationsTable;
    }

    public function getCountriesTable()
    {
        if (!$this->countriesTable){
            $sm = $this->getServiceLocator();
            
            $this->countriesTable = $sm->get('Countries\Model\CountriesTable');
        }
        return $this->countriesTable;
    }

    public function indexAction()
    {
        return new ViewModel(
                array(
                    'locations' => $this->getLocationsTable()->fetchAll(),
                )
            );
    }

    public function addAction()
    {
        $error = null;
        $countries = $this->getCountriesTable()->fetchAll();

        $form = new LocationsForm($countries);
        $form->get('submit')->setValue('Adicionar');

        $request = $this->getRequest();

        if ($request->isPost()){
            
            $location = new Locations();
            
            
            $form->setInputFilter($location->getInputFilter());
            
            $form->setData($request->getPost());
            
            if($form->isValid()){
                $location->exchangeArray($form->getData());
                
                try {
                    $this->getLocationsTable()->saveLocation($location);
                
                    return $this->redirect()->toRoute('Locations');
                } catch (\Exception $ex) {
                    
                    $error = $ex;
                }
                
                
            }
        }
        return 
            array(
                    'form' => $form,
                    'error' => $error
                );
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $error = '';

        if($id == 0){
            return $this->redirect()->toRoute('Locations',array('action' => 'add'));
        }

        try{
            $location = $this->getLocationsTable()->getLocation($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('Locations',array('action' => 'index'));
        }

        $countries = $this->getCountriesTable()->fetchAll();

        $form = new LocationsForm($countries);
        $form->bind($location);

        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();


        if($request->isPost()){
            
            
            $form->setInputFilter($location->getInputFilter());
            $form->setData($request->getPost());
            
            
            
            if($form->isValid()){
                $this->getLocationsTable()->saveLocation($location);
                
                return $this->redirect()->toRoute('Locations');
            }else{
                $error = 'Erro ao salvar no banco, tente alterar o ID';
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
            'error' => $error,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $error = '';

        if($id == 0){
            return $this->redirect()->toRoute('Locations');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()){
            
            $del = $request->getPost('del','No');
        
            
            if($del == 'Yes'){
                $id = (int) $request->getPost('id');
                $this->getLocationsTable()->deleteLocation($id);
            }
            
            return $this->redirect()->toRoute('Locations');
        }
        return array(
            
            'location_id' => $id,
            'location' => $this->getLocationsTable()->getLocation($id),
        );
    }


}

