<?php
namespace Application\Form;

use Components\Form\AbstractBaseForm;
use Laminas\Form\Element\Text;

class NewsForm extends AbstractBaseForm
{
    public function init()
    {
        parent::init();
        
        $this->add([
            'name' => 'NEWS',
            'type' => Text::class,
            'attributes' => [
                'id' => 'NEWS',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'News',
            ],
        ],['priority' => 100]);
    }
}