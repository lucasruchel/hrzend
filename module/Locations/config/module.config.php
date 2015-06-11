<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Locations\Controller\Locations' => 'Locations\Controller\LocationsController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'Locations' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/locations[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Locations\Controller\Locations',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'Locations' => __DIR__ . '/../view',
         ),
     ),
 );