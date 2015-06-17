<?php

namespace Countries\Controller;

use Countries\Form\CountriesForm;
use Countries\Model\Countries;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CountriesController extends AbstractActionController
{

    protected $countriesTable = null;

    protected $regionsTable = null;

    public function getCountriesTable()
    {
        if (!$this->countriesTable){
            $sm =  $this->getServiceLocator();
            $this->countriesTable = $sm->get('Countries\Model\CountriesTable');
        }

        return $this->countriesTable;
    }

    public function getRegionsTable()
    {
        if(!$this->regionsTable){
            $sm = $this->getServiceLocator();
            $this->regionsTable = $sm->get('Regions\Model\RegionsTable');
        }
        return $this->regionsTable;
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
        $id = stripslashes($this->params()->fromRoute('id', 0));
        $error = '';

        if(!$id){
            return $this->redirect()->toRoute('countries',array('action' => 'add'));
        }

        try{
            $country = $this->getCountriesTable()->getCountry($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('Regions',array('action' => 'index'));
        }

        $regions = $this->getRegionsTable()->fetchAll();

        $form = new CountriesForm($regions);
        $form->bind($country);

        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();


        if($request->isPost()){
            
            
            $form->setInputFilter($country->getInputFilter());
            $form->setData($request->getPost());
            
            
            
            if($form->isValid()){
                $this->getCountriesTable()->updateCountry($country);
                
                return $this->redirect()->toRoute('countries');
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

    public function removeAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $error = null;
        $regions = $this->getRegionsTable()->fetchAll();

        $form = new CountriesForm($regions);
        $form->get('submit')->setValue('Adicionar');

        $request = $this->getRequest();

        if ($request->isPost()){
            
            $country = new Countries();
            
            
            $form->setInputFilter($country->getInputFilter());
            
            $form->setData($request->getPost());
            
            if($form->isValid()){
                $country->exchangeArray($form->getData());
                
                try {
                    $this->getCountriesTable()->saveCountry($country);
                
                    return $this->redirect()->toRoute('countries');
                } catch (\Exception $ex) {
                    
                    $error = 'Erro ao salvar no banco, tente alterar o ID';
                }
                
                
            }
        }
        return 
            array(
                    'form' => $form,
                    'error' => $error
                );
    }

    public function deleteAction()
    {
        $id = stripslashes($this->params()->fromRoute('id', 0));
        $error = '';

        if(!$id){
            return $this->redirect()->toRoute('countries');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()){
            
            $del = $request->getPost('del','No');
        
            
            if($del == 'Yes'){
                $id = stripslashes($request->getPost('id'));
                $this->getCountriesTable()->deleteCountry($id);
            }
            
            return $this->redirect()->toRoute('countries');
        }
        return array(
            
            'country_id' => $id,
            'country' => $this->getCountriesTable()->getCountry($id),
        );
    }


}

