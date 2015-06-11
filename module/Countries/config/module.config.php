<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Countries\Controller\Countries' => 'Countries\Controller\CountriesController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'countries' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/countries[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Countries\Controller\Countries',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'countries' => __DIR__ . '/../view',
         ),
     ),
 );