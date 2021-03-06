<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Jobs\Controller\Jobs' => 'Jobs\Controller\JobsController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'jobs' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/jobs[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[a-zA-Z0-9-_]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Jobs\Controller\Jobs',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'jobs' => __DIR__ . '/../view',
         ),
     ),
 );