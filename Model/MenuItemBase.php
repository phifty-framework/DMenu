<?php
namespace DMenu\Model;

class MenuItemBase  extends \Phifty\Model {
const schema_proxy_class = 'DMenu\\Model\\MenuItemSchemaProxy';
const collection_class = 'DMenu\\Model\\MenuItemCollection';
const model_class = 'DMenu\\Model\\MenuItem';
const table = 'menu_items';

public static $column_names = array (
  0 => 'label',
  1 => 'title',
  2 => 'parent',
  3 => 'type',
  4 => 'data',
  5 => 'sort',
  6 => 'lang',
  7 => 'id',
);
public static $column_hash = array (
  'label' => 1,
  'title' => 1,
  'parent' => 1,
  'type' => 1,
  'data' => 1,
  'sort' => 1,
  'lang' => 1,
  'id' => 1,
);
public static $mixin_classes = array (
  0 => 'I18N\\Model\\Mixin\\I18NSchema',
);



    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
