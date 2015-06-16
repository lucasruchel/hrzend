<?php

namespace Regions\Controller;

use Regions\Form\RegionsForm;
use Regions\Model\Regions;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegionsController extends AbstractActionController
{

    protected $regionsTable = null;

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
                    'regions' => $this->getRegionsTable()->fetchAll(),
                )
            );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$id){
            return $this->redirect()->toRoute('Regions');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()){
            
            $del = $request->getPost('del','No');
        
            
            if($del == 'Yes'){
                $id = (int) $request->getPost('id');
                $this->getRegionsTable()->deleteRegion($id);
            }
            
            return $this->redirect()->toRoute('Regions');
        }
        return array(
            'region_id' => $id,
            'region' => $this->getRegionsTable()->getRegions($id),
        );
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if(!$id){
            return $this->redirect()->toRoute('Regions',array('action' => 'add'));
        }
        
        try{
            $region = $this->getRegionsTable()->getRegions($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('Regions',array('action' => 'index'));
        }
        $form = new RegionsForm();
        $form->bind($region);
        
        $form->get('submit')->setAttribute('value', 'Editar');
        
        $request = $this->getRequest();
        
        
        if($request->isPost()){
            
            
            $form->setInputFilter($region->getInputFilter());
            $form->setData($request->getPost());
            
            
            
            if($form->isValid()){
                $this->getRegionsTable()->saveRegion($region);
                
                return $this->redirect()->toRoute('Regions');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function addAction()
    {
        $form = new RegionsForm();
        $form->get('submit')->setValue('Adicionar');
        
        $request = $this->getRequest();
        
        if ($request->isPost()){
            
            $region = new Regions();
            
            
            $form->setInputFilter($region->getInputFilter());
            
            $form->setData($request->getPost());
            
            if($form->isValid()){
                $region->exchangeArray($form->getData());
                $this->getRegionsTable()->saveRegion($region);
                
                return $this->redirect()->toRoute('Regions');
            }
        }
        
        
        return array('form' => $form);
    }


}

