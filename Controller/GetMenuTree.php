<?php

namespace DMenu\Controller;
use Phifty\Controller;
use DMenu\Model\MenuItemCollection;
use DMenu\Model\MenuItem;

class GetMenuTree extends Controller
{

    function buildMenuTree( $parent = 0 )
    {
        // find top menu item first
        $data  = array();
        $items = new MenuItemCollection;
        $items->where( array('parent' => $parent ) );
        $items->order('ordering','asc')->order('id','asc');
        $items->fetch();
        foreach( $items->items() as $item ) {
            if( $item->type == "folder" ) {
                $itemData = $item->getData();
                $itemData['items'] = $this->buildMenuTree( $item->id );
                $data[] = $itemData;
            } else {
                $data[] = $item->getData();
            }
        }
        return $data;
    }

    function indexAction()
    {
        $data = $this->buildMenuTree();
        return $this->renderJson( $data );
    }
}

