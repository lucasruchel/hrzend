<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Job_history\Controller\Job_history' => 'Job_history\Controller\Job_historyController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'job_history' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/jobhistory[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Job_history\Controller\Job_history',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'job_history' => __DIR__ . '/../view',
         ),
     ),
 );