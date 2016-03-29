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
      3 => 'is_hidden',
      4 => 'parent_id',
      5 => 'type',
      6 => 'require_login',
      7 => 'class_names',
      8 => 'extra_attrs',
      9 => 'data',
      10 => 'sort',
      11 => 'lang',
      12 => 'ordering',
    );
    public static $column_hash = array (
      'id' => 1,
      'label' => 1,
      'title' => 1,
      'is_hidden' => 1,
      'parent_id' => 1,
      'type' => 1,
      'require_login' => 1,
      'class_names' => 1,
      'extra_attrs' => 1,
      'data' => 1,
      'sort' => 1,
      'lang' => 1,
      'ordering' => 1,
    );
    public static $mixin_classes = array (
      0 => 'SortablePlugin\\Model\\Mixin\\OrderingSchema',
      1 => 'I18N\\Model\\Mixin\\I18NSchema',
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
    public function getIsHidden()
    {
            return $this->get('is_hidden');
    }
    public function getParentId()
    {
            return $this->get('parent_id');
    }
    public function getType()
    {
            return $this->get('type');
    }
    public function getRequireLogin()
    {
            return $this->get('require_login');
    }
    public function getClassNames()
    {
            return $this->get('class_names');
    }
    public function getExtraAttrs()
    {
            return $this->get('extra_attrs');
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
    public function getOrdering()
    {
            return $this->get('ordering');
    }
}
