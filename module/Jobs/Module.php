<?php
namespace Jobs;
 use Jobs\Model\Jobs;
 
 use Jobs\Model\JobsTable;

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
                 'Jobs\Model\JobsTable' =>  function($sm) {
                     $tableGateway = $sm->get('JobsTableGateway');
                     $table = new JobsTable($tableGateway);
                     return $table;
                 },
                 'JobsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new Jobs());
                     
                     return new TableGateway('jobs', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }


}
