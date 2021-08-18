<?php
namespace Application\Form\Factory;

use Application\Form\NewsForm;
use Psr\Container\ContainerInterface;

class NewsFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('hyperlink-model-adapter');
        
        $form = new NewsForm();
        return $form;
    }
}