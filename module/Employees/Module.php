<?php
namespace Employees;

use Employees\Model\Employees;
use Employees\Model\EmployeesTable;

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
                 'Employees\Model\EmployeesTable' =>  function($sm) {
                     $tableGateway = $sm->get('EmployeesTableGateway');
                     $table = new EmployeesTable($tableGateway);
                     return $table;
                 },
                 'EmployeesTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
                     
                     $resultSetPrototype = new HydratingResultSet();
                     $resultSetPrototype->setHydrator(new ObjectProperty());
                     $resultSetPrototype->setObjectPrototype(new Employees());
                     
                     return new TableGateway('employees', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
