<?php 
namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class Functions extends AbstractHelper
{
    public function __invoke($route, $action, $key, $label)
    {
        $string = sprintf('<a class="dropdown-item" href="%s">%s</a>', $this->view->url($route, ['action' => $action, 'uuid' => $key]), $label);
        return $string;
    }
}