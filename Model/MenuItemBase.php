<?php
namespace DMenu\Model;
use LazyRecord\Schema\SchemaLoader;
use LazyRecord\Result;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use LazyRecord\BaseModel;
class MenuItemBase
    extends BaseModel
{
    const SCHEMA_PROXY_CLASS = 'DMenu\\Model\\MenuItemSchemaProxy';
    const COLLECTION_CLASS = 'DMenu\\Model\\MenuItemCollection';
    const MODEL_CLASS = 'DMenu\\Model\\MenuItem';
    const TABLE = 'menu_items';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
    const FIND_BY_PRIMARY_KEY_SQL = 'SELECT * FROM menu_items WHERE id = :id LIMIT 1';
    public static $column_names = array (
      0 => 'id',
      1 => 'label',
      2 => 'title',
      3 => 'parent_id',
      4 => 'type',
      5 => 'data',
      6 => 'sort',
      7 => 'lang',
    );
    public static $column_hash = array (
      'id' => 1,
      'label' => 1,
      'title' => 1,
      'parent_id' => 1,
      'type' => 1,
      'data' => 1,
      'sort' => 1,
      'lang' => 1,
    );
    public static $mixin_classes = array (
      0 => 'I18N\\Model\\Mixin\\I18NSchema',
    );
    protected $table = 'menu_items';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = SchemaLoader::load('DMenu\\Model\\MenuItemSchemaProxy');
    }
    public function getId()
    {
            return $this->get('id');
    }
    public function getLabel()
    {
            return $this->get('label');
    }
    public function getTitle()
    {
            return $this->get('title');
    }
    public function getParentId()
    {
            return $this->get('parent_id');
    }
    public function getType()
    {
            return $this->get('type');
    }
    public function getData()
    {
            return $this->get('data');
    }
    public function getSort()
    {
            return $this->get('sort');
    }
    public function getLang()
    {
            return $this->get('lang');
    }
}
