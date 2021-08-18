<?php
namespace Application\Controller\Factory;

use Application\Controller\NewsController;
use Application\Form\NewsForm;
use Application\Model\NewsModel;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class NewsControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new NewsController();
        $adapter = $container->get('hyperlink-model-adapter');
        $form = $container->get('FormElementManager')->get(NewsForm::class);
        $model = new NewsModel($adapter);
        
        $controller->setDbAdapter($adapter);
        $controller->setModel($model);
        $controller->setForm($form);
        return $controller;
    }
}