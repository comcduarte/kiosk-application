<?php
namespace Application\Controller\Factory;

use Application\Controller\SectionController;
use Application\Form\SectionForm;
use Application\Model\SectionModel;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SectionControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new SectionController();
        $adapter = $container->get('hyperlink-model-adapter');
        $form = $container->get('FormElementManager')->get(SectionForm::class);
        $model = new SectionModel($adapter);
        
        $controller->setDbAdapter($adapter);
        $controller->setModel($model);
        $controller->setForm($form);
        return $controller;
    }

    
}