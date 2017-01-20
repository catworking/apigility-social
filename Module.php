<?php
namespace ApigilitySocial;

use Zend\Config\Config;
use Zend\Mvc\MvcEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        $doctrine_config = new Config(include __DIR__ . '/config/doctrine.config.php');
        $service_config = new Config(include __DIR__ . '/config/service.config.php');
        $manual_config = new Config(include __DIR__ . '/config/manual.config.php');

        $module_config = new Config(include __DIR__ . '/config/module.config.php');
        $module_config->merge($doctrine_config);
        $module_config->merge($service_config);
        $module_config->merge($manual_config);

        return $module_config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $services    = $application->getServiceManager();

        $userEvents = $services->get('ApigilityUser\Service\UserService')->getEventManager();
        $person_listener = new PersonListener($services);
        $person_listener->attach($userEvents);

        $personEvents = $services->get('ApigilitySocial\Service\PersonService')->getEventManager();
        $requirement_listener = new RequirementListener($services);
        $requirement_listener->attach($personEvents);

        $contractEvents = $services->get('ApigilityVIP\Service\ContractService')->getEventManager();
        $personContract_listener = new PersonContractListener($services);
        $personContract_listener->attach($contractEvents);
    }
}
