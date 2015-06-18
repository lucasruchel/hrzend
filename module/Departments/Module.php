<?php
namespace Departments;
 use Departments\Model\Departments;
 
 use Departments\Model\DepartmentsTable;

 use Locations\Model\Locations;
 
 use Zend\Db\TableGateway\TableGateway;

use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Departments\Model\DepartmentsTable' =>  function($sm) {
                     $tableGateway = $sm->get('DepartmentsTableGateway');
                     $table = new DepartmentsTable($tableGateway);
                     return $table;
                 },
                 'DepartmentsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new Departments());
                     
                     return new TableGateway('departments', $dbAdapter, null, $resultSetPrototype);
                },
                'Locations\Model\LocationsTable' =>  function($sm) {
                     $tableGateway = $sm->get('LocationsTableGateway');
                     $table = new LocationsTable($tableGateway);
                     return $table;
                 },
                 'LocationsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new Locations());
                     
                     return new TableGateway('locations', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }


}
