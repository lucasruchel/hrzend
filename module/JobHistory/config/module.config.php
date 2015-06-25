<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'JobHistory\Controller\JobHistory' => 'JobHistory\Controller\JobHistoryController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'jobshistory' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/jobhistory[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[a-zA-Z][a-zA-Z0-9]*',
                     ),
                     'defaults' => array(
                         'controller' => 'JobHistory\Controller\JobHistory',
                         'action'     => 'index',
                     ),
                 ),
             ),
             
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'jobshistory' => __DIR__ . '/../view',
         ),
     ),
 );