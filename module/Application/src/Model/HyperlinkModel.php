<?php
namespace Application\Model;

use Components\Model\AbstractBaseModel;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Sql;
use Exception;

class HyperlinkModel extends AbstractBaseModel
{
    public $CAPTION;
    public $URL;
    public $ICON;
    public $COLOR;
    public $TYPE;
    public $PRIORITY;
    
    public function __construct($adapter)
    {
        parent::__construct($adapter);
        $this->setTableName('links');
    }
    
    public function assign($section_uuid)
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
            $this->UUID,
            $section_uuid,
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
    
    public function unassign($section_uuid = NULL, $join_uuid = NULL)
    {
        $sql = new Sql($this->dbAdapter);
        
        $delete = new Delete();
        $delete->from('section_links');
        
        if ($section_uuid != NULL ) {
            $delete->where(['LINK' => $this->UUID, 'SECTION' => $section_uuid]);
        }
        
        if ($join_uuid != NULL) {
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