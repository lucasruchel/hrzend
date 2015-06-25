<?php

namespace Jobs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Jobs\Model\Jobs;          // <-- Add this import
use Jobs\Form\JobsForm;

class JobsController extends AbstractActionController
{
    protected $jobsTable;
    
    public function getJobsTable(){
        if (!$this->jobsTable){
            $sm =  $this->getServiceLocator();
            $this->jobsTable = $sm->get('Jobs\Model\JobsTable');
        }
        
        return $this->jobsTable;
    }

        public function indexAction()
    {
        $paginator = $this->getJobsTable()->fetchAll(true);
     
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     
        $paginator->setItemCountPerPage(10);
        return new ViewModel(
                array(
                    'jobs' => $paginator,
                )
            );
    }

    public function addAction()
     {
        
         $form = new JobsForm();
         $form->get('submit')->setValue('Adicionar');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $jobs = new Jobs();
             $form->setInputFilter($jobs->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $jobs->exchangeArray($form->getData());
                 $this->getJobsTable()->saveJobs($jobs);

                 
                 return $this->redirect()->toRoute('jobs');
             }
         }
         return array('form' => $form);
     }
     
     public function deleteAction()
     {
         $id = $this->params()->fromRoute('id', 0);
         
         
         if (!$id) {
             return $this->redirect()->toRoute('jobs');
         }
      
         $request = $this->getRequest();
      
        
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             
             if ($del == 'Yes') {
                 
                 $this->getJobsTable()->deleteJobs($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('jobs');
         }

         return array(
             'id'    => $id,
             'jobs' => $this->getJobsTable()->getJobs($id)
         );
     }
     
    
    public function editAction()
     {
         $id = $this->params()->fromRoute('id', 0);
       
         if (!$id) {
             return $this->redirect()->toRoute('jobs', array(
                 'action' => 'add'
             ));
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $jobs = $this->getJobsTable()->getJobs($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('jobs', array(
                 'action' => 'index'
             ));
         }

         $form  = new JobsForm();
         $form->bind($jobs);
         $form->get('submit')->setAttribute('value', 'Editar');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($jobs->getInputFilter());
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
                 $this->getJobsTable()->updateJobs($jobs);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('jobs');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

}

