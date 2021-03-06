<?php
namespace Application\Form\Factory;

use Application\Form\HyperlinkForm;
use Psr\Container\ContainerInterface;

class HyperlinkFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('hyperlink-model-adapter');
        
        $form = new HyperlinkForm();
        return $form;
    }
}