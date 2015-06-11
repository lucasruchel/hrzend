<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Regions\Controller\Regions' => 'Regions\Controller\RegionsController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'Regions' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/regions[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Regions\Controller\Regions',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'Regions' => __DIR__ . '/../view',
         ),
     ),
 );