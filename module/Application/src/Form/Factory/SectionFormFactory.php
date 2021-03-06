<?php
namespace Application\Form\Factory;

use Application\Form\SectionForm;
use Psr\Container\ContainerInterface;

class SectionFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('hyperlink-model-adapter');
        
        $form = new SectionForm();
        return $form;
    }
}