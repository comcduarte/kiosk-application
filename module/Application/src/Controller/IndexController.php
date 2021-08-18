<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\HyperlinkModel;
use Application\Model\NewsModel;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Join;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Where;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Exception;

class IndexController extends AbstractActionController
{
    use AdapterAwareTrait;
    
    public function indexAction()
    {
        $view = new ViewModel();
        $this->layout('layout/metromega');
        
        $section = $this->params()->fromRoute('section','%');
        
        $model = new HyperlinkModel($this->adapter);
        
        /*******************************/
        
        $sql = new Sql($this->adapter);
        
        $select = new Select();
        $select->from('section_links')
        ->join('links', 'section_links.LINK = links.UUID', ['*'], Join::JOIN_INNER)
        ->join('sections', 'section_links.SECTION = sections.UUID', ['UUID_S'=>'UUID', 'Name' => 'NAME'], Join::JOIN_INNER);
        
        $predicate = new Where();
        $predicate->equalTo('links.STATUS', $model::ACTIVE_STATUS);
        $predicate->like('sections.UUID', $section);
        
        $select->where($predicate);
        $select->order(['sections.PRIORITY', 'links.PRIORITY']);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new ResultSet();
        try {
            $results = $statement->execute();
            $resultSet->initialize($results);
        } catch (Exception $e) {
            return $e;
        }
        
        $data = [];
        
        foreach ($resultSet->toArray() as $record) {
            $data[$record['Name']][] = $record;
        }
        
        $news = new NewsModel($this->adapter);
        foreach ($news->fetchAll() as $record) {
            $this->flashMessenger()->addErrorMessage($record['NEWS']);
        }
                
        $view->setVariable('data', $data);
        return $view;
    }
}
