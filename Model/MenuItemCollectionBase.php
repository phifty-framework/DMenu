<?php
namespace DMenu\Model;
use LazyRecord\BaseCollection;
class MenuItemCollectionBase
    extends BaseCollection
{
    const SCHEMA_PROXY_CLASS = 'DMenu\\Model\\MenuItemSchemaProxy';
    const MODEL_CLASS = 'DMenu\\Model\\MenuItem';
    const TABLE = 'menu_items';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
}
