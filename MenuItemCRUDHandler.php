<?php
namespace DMenu;
use Phifty\Bundle;
use AdminUI\CRUDHandler;

class MenuItemCRUDHandler extends CRUDHandler
{
    /* CRUD Attributes */
    public $modelClass = 'DMenu\Model\MenuItem';
    public $crudId     = 'menu_item';

    // public $listColumns = array( 'id', 'thumb', 'name' , 'lang' , 'subtitle' , 'sn' );
    // public $filterColumns = array();
    // public $quicksearchFields = array('name');

    public $canCreate = true;
    public $canUpdate = true;
    public $canDelete = true;

    public $canBulkEdit = true;
    public $canBulkDelete = true;
    public $canBulkCopy = false;
    public $canEditInNewWindow = false;

    protected $searchQueryFields = ['parent_id', 'lang', 'type'];

    protected $applyRequestFields = ['parent_id', 'lang', 'type'];

    public function getCollection()
    {
        return parent::getCollection();
    }
}

