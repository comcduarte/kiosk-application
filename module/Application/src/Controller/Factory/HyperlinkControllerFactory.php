<?php
namespace Application\Controller\Factory;


use Application\Controller\HyperlinkController;
use Application\Form\HyperlinkForm;
use Application\Model\HyperlinkModel;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HyperlinkControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new HyperlinkController();
        $adapter = $container->get('hyperlink-model-adapter');
        $form = $container->get('FormElementManager')->get(HyperlinkForm::class);
        $model = new HyperlinkModel($adapter);
        
        $controller->setDbAdapter($adapter);
        $controller->setModel($model);
        $controller->setForm($form);
        return $controller;
    }
}