<?php

namespace JobHistory\Controller;

use JobHistory\Form\JobHistoryForm;
use JobHistory\Model\JobHistory;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JobHistoryController extends AbstractActionController
{
    protected $jobHistoryTable= null;
    
    public function getJobHistoryTable(){
        if (!$this->jobHistoryTable){
            $sm =  $this->getServiceLocator();
            
            $this->jobHistoryTable = $sm->get('JobHistory\Model\JobHistoryTable');
        }
        
        return $this->jobHistoryTable;
    }
    protected function getViewHelper($helperName)
    {
        return $this->getServiceLocator()->get('viewhelpermanager')->get($helperName);
    }

        public function indexAction()
        {
            $form = new JobHistoryForm();
            
            $renderer = $this->serviceLocator->get('Zend\View\Renderer\RendererInterface');

            $this->getViewHelper('HeadScript')->appendFile($renderer->basePath('/js/formTrigger.js'));
            
            $params = $this->params()->fromQuery();
            
            if(count($params)>1){
                
                $jobHistory = new JobHistory();
                $jobHistory->exchangeArray($params);
                
                $form->bind($jobHistory);
            }
            
            
            $paginator = $this->getJobHistoryTable()->fetchAll(true,$params);

            $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));

            $paginator->setItemCountPerPage(10);
            
            return new ViewModel(
                array(
                    'jobHistory' => $paginator,
                           'form' => $form,
                    'params' => $params,
                    )
            );
        }
        public function relatorioAction()
        {
            return new ViewModel();
           
        }
}

