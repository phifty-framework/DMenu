<?php
namespace DMenu\Model;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\RuntimeColumn;
use LazyRecord\Schema\Relationship\Relationship;
class MenuItemSchemaProxy
    extends RuntimeSchema
{
    const schema_class = 'DMenu\\Model\\MenuItemSchema';
    const model_name = 'MenuItem';
    const model_namespace = 'DMenu\\Model';
    const COLLECTION_CLASS = 'DMenu\\Model\\MenuItemCollection';
    const MODEL_CLASS = 'DMenu\\Model\\MenuItem';
    const PRIMARY_KEY = 'id';
    const TABLE = 'menu_items';
    const LABEL = 'MenuItem';
    public static $column_hash = array (
      'id' => 1,
      'label' => 1,
      'title' => 1,
      'is_hidden' => 1,
      'parent_id' => 1,
      'type' => 1,
      'expander' => 1,
      'require_login' => 1,
      'handle' => 1,
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
    public $columnNames = array (
      0 => 'id',
      1 => 'label',
      2 => 'title',
      3 => 'is_hidden',
      4 => 'parent_id',
      5 => 'type',
      6 => 'expander',
      7 => 'require_login',
      8 => 'handle',
      9 => 'class_names',
      10 => 'extra_attrs',
      11 => 'data',
      12 => 'sort',
      13 => 'lang',
      14 => 'ordering',
    );
    public $primaryKey = 'id';
    public $columnNamesIncludeVirtual = array (
      0 => 'id',
      1 => 'label',
      2 => 'title',
      3 => 'is_hidden',
      4 => 'parent_id',
      5 => 'type',
      6 => 'expander',
      7 => 'require_login',
      8 => 'handle',
      9 => 'class_names',
      10 => 'extra_attrs',
      11 => 'data',
      12 => 'sort',
      13 => 'lang',
      14 => 'ordering',
    );
    public $label = 'MenuItem';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public $relations;
    public function __construct()
    {
        $this->relations = array( 
      'parent' => \LazyRecord\Schema\Relationship\BelongsTo::__set_state(array( 
      'data' => array( 
          'type' => 3,
          'self_schema' => 'DMenu\\Model\\MenuItemSchema',
          'self_column' => 'parent_id',
          'foreign_schema' => 'DMenu\\Model\\MenuItemSchema',
          'foreign_column' => 'id',
        ),
      'accessor' => 'parent',
      'where' => NULL,
      'orderBy' => array( 
        ),
      'onUpdate' => NULL,
      'onDelete' => NULL,
    )),
      'children' => \LazyRecord\Schema\Relationship\HasMany::__set_state(array( 
      'data' => array( 
          'type' => 1,
          'self_schema' => 'DMenu\\Model\\MenuItemSchema',
          'self_column' => 'id',
          'foreign_schema' => 'DMenu\\Model\\MenuItemSchema',
          'foreign_column' => 'parent_id',
        ),
      'accessor' => 'children',
      'where' => NULL,
      'orderBy' => array( 
        ),
      'onUpdate' => NULL,
      'onDelete' => 'CASCADE',
    )),
    );
        $this->columns[ 'id' ] = new RuntimeColumn('id',array( 
      'locales' => NULL,
      'attributes' => array( 
          'autoIncrement' => true,
          'renderAs' => 'HiddenInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'id',
      'primary' => true,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => true,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'autoIncrement' => true,
      'renderAs' => 'HiddenInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'label' ] = new RuntimeColumn('label',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 128,
          'label' => '標籤',
          'required' => true,
        ),
      'name' => 'label',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => true,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 128,
      'label' => '標籤',
      'required' => true,
    ));
        $this->columns[ 'title' ] = new RuntimeColumn('title',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 256,
          'label' => '標題',
        ),
      'name' => 'title',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 256,
      'label' => '標題',
    ));
        $this->columns[ 'is_hidden' ] = new RuntimeColumn('is_hidden',array( 
      'locales' => NULL,
      'attributes' => array( 
          'default' => false,
          'label' => '隱藏',
          'renderAs' => 'CheckboxInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'is_hidden',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'boolean',
      'isa' => 'bool',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'default' => false,
      'label' => '隱藏',
      'renderAs' => 'CheckboxInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'parent_id' ] = new RuntimeColumn('parent_id',array( 
      'locales' => NULL,
      'attributes' => array( 
          'default' => 0,
          'label' => '上層選單',
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
              'allow_empty' => 0,
            ),
        ),
      'name' => 'parent_id',
      'primary' => NULL,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'default' => 0,
      'label' => '上層選單',
      'renderAs' => 'SelectInput',
      'widgetAttributes' => array( 
          'allow_empty' => 0,
        ),
    ));
        $this->columns[ 'type' ] = new RuntimeColumn('type',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 20,
          'required' => true,
          'label' => '類型',
          'default' => function() { return 'link'; },
          'validValues' => array( 
              '連結' => 'link',
              '選單' => 'folder',
              '頁面' => 'page',
              '動態' => 'dynamic',
            ),
        ),
      'name' => 'type',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => true,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 20,
      'required' => true,
      'label' => '類型',
      'default' => function() { return 'link'; },
      'validValues' => array( 
          '連結' => 'link',
          '選單' => 'folder',
          '頁面' => 'page',
          '動態' => 'dynamic',
        ),
    ));
        $this->columns[ 'expander' ] = new RuntimeColumn('expander',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 60,
          'label' => '展開器',
          'renderAs' => 'TextInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'expander',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 60,
      'label' => '展開器',
      'renderAs' => 'TextInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'require_login' ] = new RuntimeColumn('require_login',array( 
      'locales' => NULL,
      'attributes' => array( 
          'default' => false,
          'label' => '須登入',
          'renderAs' => 'CheckboxInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'require_login',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'boolean',
      'isa' => 'bool',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'default' => false,
      'label' => '須登入',
      'renderAs' => 'CheckboxInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'handle' ] = new RuntimeColumn('handle',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 30,
          'unique' => true,
          'label' => 'Handle',
        ),
      'name' => 'handle',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 30,
      'unique' => true,
      'label' => 'Handle',
    ));
        $this->columns[ 'class_names' ] = new RuntimeColumn('class_names',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 200,
          'label' => 'Class names',
        ),
      'name' => 'class_names',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => false,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 200,
      'label' => 'Class names',
    ));
        $this->columns[ 'extra_attrs' ] = new RuntimeColumn('extra_attrs',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 200,
          'label' => 'Extra Element Attributes',
        ),
      'name' => 'extra_attrs',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => false,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 200,
      'label' => 'Extra Element Attributes',
    ));
        $this->columns[ 'data' ] = new RuntimeColumn('data',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 200,
          'label' => '網址 (或參數)',
        ),
      'name' => 'data',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 200,
      'label' => '網址 (或參數)',
    ));
        $this->columns[ 'sort' ] = new RuntimeColumn('sort',array( 
      'locales' => NULL,
      'attributes' => array( 
          'default' => 0,
        ),
      'name' => 'sort',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'smallint',
      'isa' => 'int',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'default' => 0,
    ));
        $this->columns[ 'lang' ] = new RuntimeColumn('lang',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 12,
          'validValues' => function() {
                    return array_flip( kernel()->locale->available() );
                },
          'label' => '語言',
          'default' => function() {
                    $bundle = \I18N\I18N::getInstance();
                    if ($lang = $bundle->config('default_lang') ) {
                        return $lang;
                    }
                    return kernel()->locale->getDefault();
                },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
              'allow_empty' => true,
            ),
        ),
      'name' => 'lang',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 12,
      'validValues' => function() {
                    return array_flip( kernel()->locale->available() );
                },
      'label' => '語言',
      'default' => function() {
                    $bundle = \I18N\I18N::getInstance();
                    if ($lang = $bundle->config('default_lang') ) {
                        return $lang;
                    }
                    return kernel()->locale->getDefault();
                },
      'renderAs' => 'SelectInput',
      'widgetAttributes' => array( 
          'allow_empty' => true,
        ),
    ));
        $this->columns[ 'ordering' ] = new RuntimeColumn('ordering',array( 
      'locales' => NULL,
      'attributes' => array( 
          'default' => 0,
          'renderAs' => 'HiddenInput',
          'widgetAttributes' => array( 
            ),
          'label' => '排序編號',
        ),
      'name' => 'ordering',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'default' => 0,
      'renderAs' => 'HiddenInput',
      'widgetAttributes' => array( 
        ),
      'label' => '排序編號',
    ));
    }
}
