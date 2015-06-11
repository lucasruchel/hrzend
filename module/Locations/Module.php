<?php
namespace Locations;

use Locations\Model\Locations;
use Locations\Model\LocationsTable;

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
