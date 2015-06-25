<?php
namespace JobHistory;

use JobHistory\Model\JobHistory;
use JobHistory\Model\JobHistoryTable;

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
                 'JobHistory\Model\JobHistoryTable' =>  function($sm) {
                     $tableGateway = $sm->get('JobHistoryTableGateway');
                     $table = new JobHistoryTable($tableGateway);
                     return $table;
                 },
                 'JobHistoryTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new JobHistory());
                     
                     return new TableGateway('jobHistory', $dbAdapter, null, $resultSetPrototype);
                },                
                 
            ),
        );
    }
}
