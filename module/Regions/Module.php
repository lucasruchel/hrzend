<?php
namespace Regions;

use Regions\Model\Regions;
use Regions\Model\RegionsTable;

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
                 'Regions\Model\RegionsTable' =>  function($sm) {
                     $tableGateway = $sm->get('RegionsTableGateway');
                     $table = new RegionsTable($tableGateway);
                     return $table;
                 },
                 'RegionsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new Regions());
                     
                     return new TableGateway('regions', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}
