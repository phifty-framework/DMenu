<?php
namespace DMenu;
use Phifty\Bundle;
use AdminUI\CRUDHandler;
use DMenu\Model\MenuItem;

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

    public $defaultOrder = array('sort', 'ASC');

    protected $searchQueryFields = ['parent_id', 'lang', 'type'];

    protected $applyRequestFields = ['parent_id', 'lang', 'type'];

    public function getCollection()
    {
        return parent::getCollection();
    }

    public function searchAction()
    {
        $data = [];
        $request = $this->getRequest();
        $parentId = intval($request->param('parent_id'));
        $collection = $this->search($request);
        if ($parentId) {
            $menu = new MenuItem;
            if ($menu->find($parentId)->success) {
                $data['current'] = $menu->toArray();
                $cur = $menu->parent;
                while ($cur->id) {
                    $data['parents'][] = $cur->toArray();
                    $cur = $cur->parent;
                }
            }
        } else {
            $collection->where()
                ->equal('parent_id', 0)
                ->or()
                ->is('parent_id', null)
                ;
        }
        $data['items'] = $collection->toArray();
        return $this->toJson($data);
    }

}

