<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $this->layout('layout/metromega');
        
        $data = [
            'Name' => 'data',
        ];
        $view->setVariable('data', $data);
        
        return $view;
    }
}
