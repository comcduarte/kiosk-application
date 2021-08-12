<?php
namespace Application\Controller;

use Application\Form\SectionAssignmentForm;
use Components\Controller\AbstractBaseController;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Join;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Predicate\Like;

class HyperlinkController extends AbstractBaseController
{
    public function updateAction()
    {
        $view = parent::updateAction();
        $view->setTemplate('application/hyperlink/update.phtml');
        
        $primary_key = $this->params()->fromRoute(strtolower($this->model->getPrimaryKey()),0);
        
        /****************************************
         *          Retrieve Subtable
         ****************************************/
        $sql = new Sql($this->adapter);
        $select = new Select();
        $select->columns(['UUID'])      /*** Get primary Key from Relational Table ***/
        ->from('section_links')
        ->join('sections', 'section_links.SECTION = sections.UUID', ['UUID_S'=>'UUID', 'Name' => 'NAME'], Join::JOIN_INNER)
        ->where([new Like('LINK', $primary_key)]);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        
        $results = $statement->execute();
        $resultSet = new ResultSet($results);
        $resultSet->initialize($results);
        $sections = $resultSet->toArray();
        
        $subtable_params = [
            'title' => 'Sections',
            'data' => $sections,
            'primary_key' => 'UUID',
            'route' => 'sections/default',
            'params' => [
                [
                    'key' => 'UUID_S',
                    'action' => 'update',
                    'route' => 'sections/default',
                    'label' => 'Update',
                ],
                [
                    'key' => 'UUID',
                    'action' => 'unassign',
                    'route' => 'sections/default',
                    'label' => 'Unassign',
                ],
            ],
        ];
        
        $form = new SectionAssignmentForm('SECTION_ASSIGN_FORM');
        $form->setDbAdapter($this->adapter);
        $form->init();
        $form->setAttribute('action', $this->url()->fromRoute('sections/default', ['action' => 'assign']));
        $form->get('LINK')->setValue($primary_key);
        
        $subform_params = [
            'title' => 'Add Link to Section',
            'form' => $form,
        ];
        
        $view->setVariable('subform_params', $subform_params);
        
        $view->setVariable('subtable_params', $subtable_params);
        
        return $view;
    }
}