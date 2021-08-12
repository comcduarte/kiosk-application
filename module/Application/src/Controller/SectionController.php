<?php
namespace Application\Controller;

use Components\Controller\AbstractBaseController;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Join;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Predicate\Like;

class SectionController extends AbstractBaseController
{
    public function updateAction()
    {
        $view = parent::updateAction();
        $view->setTemplate('application/section/update.phtml');
        
        $primary_key = $this->params()->fromRoute(strtolower($this->model->getPrimaryKey()),0);
        
        /****************************************
         *          Retrieve Subtable
         ****************************************/
        $sql = new Sql($this->adapter);
        $select = new Select();
        $select->columns(['UUID'])      /*** Get primary Key from Relational Table ***/
        ->from('section_links')
        ->join('links', 'section_links.LINK = links.UUID', ['UUID_L'=>'UUID', 'Caption' => 'CAPTION'], Join::JOIN_INNER)
        ->where([new Like('SECTION', $primary_key)]);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        
        $results = $statement->execute();
        $resultSet = new ResultSet($results);
        $resultSet->initialize($results);
        $links = $resultSet->toArray();
        
        $subtable_params = [
            'title' => 'Links',
            'data' => $links,
            'primary_key' => 'UUID',
            'route' => 'links/default',
            'params' => [
                [
                    'key' => 'UUID_L',
                    'action' => 'update',
                    'route' => 'links/default',
                    'label' => 'Update',
                ],
                //                 [
                    //                     'key' => 'UUID',
                    //                     'action' => 'unassign',
                    //                     'route' => 'links/default',
                    //                     'label' => 'Unassign',
                    //                 ],
            ],
        ];
        
        $view->setVariable('subtable_params', $subtable_params);
        
        return $view;
    }
}