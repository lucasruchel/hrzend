<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Employees\Controller\Employees' => 'Employees\Controller\EmployeesController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'employees' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/employees[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Employees\Controller\Employees',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'employees' => __DIR__ . '/../view',
         ),
     ),
 );