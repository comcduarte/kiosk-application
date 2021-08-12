<?php
namespace Application\Model;

use Components\Model\AbstractBaseModel;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Sql;
use Exception;

class SectionModel extends AbstractBaseModel
{
    public $NAME;
    public $PRIORITY;
    
    public function __construct($adapter)
    {
        parent::__construct($adapter);
        $this->setTableName('sections');
    }
    
    public function assign($link_uuid)
    {
        $sql = new Sql($this->dbAdapter);
        $uuid = $this->generate_uuid();
        
        $columns = [
            'UUID',
            'LINK',
            'SECTION',
        ];
        
        $values = [
            $uuid->value,
            $link_uuid,
            $this->UUID,
        ];
        
        $insert = new Insert();
        $insert->into('section_links');
        $insert->columns($columns);
        $insert->values($values);
        
        $statement = $sql->prepareStatementForSqlObject($insert);
        
        try {
            $statement->execute();
        } catch (Exception $e) {
            return $e;
        }
        return $this;
    }
    
    public function unassign($link_uuid = NULL, $join_uuid = NULL)
    {
        $sql = new Sql($this->dbAdapter);
        
        $delete = new Delete();
        $delete->from('section_links');
        
        if ($link_uuid) {
            $delete->where(['SECTION' => $this->UUID, 'LINK' => $link_uuid]);
        }
        
        if ($join_uuid) {
            $delete->where(['UUID' => $join_uuid]);
        }
        
        $statement = $sql->prepareStatementForSqlObject($delete);
        
        try {
            $statement->execute();
        } catch (Exception $e) {
            return $e;
        }
        return $this;
    }
}