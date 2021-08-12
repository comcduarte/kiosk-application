<?php
namespace Application\Form;

use Components\Form\AbstractBaseForm;
use Laminas\Form\Element\Text;

class SectionForm extends AbstractBaseForm
{
    public function init()
    {
        parent::init();
        
        $this->add([
            'name' => 'NAME',
            'type' => Text::class,
            'attributes' => [
                'id' => 'NAME',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Section Name',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'PRIORITY',
            'type' => Text::class,
            'attributes' => [
                'id' => 'PRIORITY',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Priority',
            ],
        ],['priority' => 100]);
    }
}