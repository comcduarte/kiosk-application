<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HyperlinkModelAdapterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = new Adapter($container->get('hyperlink-model-adapter-config'));
        return $adapter;
    }
}