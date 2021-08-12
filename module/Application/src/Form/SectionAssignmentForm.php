<?php
namespace Application\Form;

use Components\Form\AbstractBaseForm;
use Components\Form\Element\DatabaseSelect;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Form\Element\Hidden;

class SectionAssignmentForm extends AbstractBaseForm
{
    use AdapterAwareTrait;
    
    public function init()
    {
        parent::init();
        
        $this->add([
            'name' => 'SECTION',
            'type' => DatabaseSelect::class,
            'attributes' => [
                'id' => 'SECTION',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Section',
                'database_adapter' => $this->adapter,
                'database_table' => 'sections',
                'database_id_column' => 'UUID',
                'database_value_columns' => [
                    'NAME',
                ],
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'LINK',
            'type' => Hidden::class,
            'attributes' => [
                'id' => 'LINK',
                'class' => 'form-control',
            ],
        ],['priority' => 0]);
        
        $this->remove('UUID');
        $this->remove('STATUS');
    }
}