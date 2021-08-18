<?php
namespace Application\Model;

use Components\Model\AbstractBaseModel;

class NewsModel extends AbstractBaseModel
{
    public $NEWS;
    
    public function __construct($adapter)
    {
        parent::__construct($adapter);
        $this->setTableName('news');
    }
}