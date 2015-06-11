<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Departments\Controller\Departments' => 'Departments\Controller\DepartmentsController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'departments' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/departments[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Departments\Controller\Departments',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'departments' => __DIR__ . '/../view',
         ),
     ),
 );