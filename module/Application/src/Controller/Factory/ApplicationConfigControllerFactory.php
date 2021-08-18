<?php
namespace Application\Controller\Factory;

use Application\Controller\ApplicationConfigController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApplicationConfigControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new ApplicationConfigController();
        $adapter = $container->get('hyperlink-model-adapter');
        $controller->setDbAdapter($adapter);
        return $controller;
    }
}