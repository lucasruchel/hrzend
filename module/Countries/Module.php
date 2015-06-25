<?php
namespace Countries;
use Countries\Model\Countries;
use Countries\Model\CountriesTable;

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
                 'Countries\Model\CountriesTable' =>  function($sm) {
                     $tableGateway = $sm->get('CountriesTableGateway');
                     $table = new CountriesTable($tableGateway);
                     return $table;
                 },
                 'CountriesTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new Countries());
                     
                     return new TableGateway('countries', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }


}
