<?php
namespace DMenu\Controller;
use DMenu\Model\MenuItemCollection;
use Phifty\Controller;
# use DMenu\Model\MenuItem;

class GetMenuItems extends Controller
{
    function indexAction()
    {
        $parentId = $this->request->param('parent');
        $lang     = $this->request->param('lang');
        $items = new MenuItemCollection;

        /* if parent is not specified, query the top level */
        if( $parentId )
            $items->where(array( 'lang' => $lang , 'parent' => $parentId ) );
        else
            $items->where(array( 'lang' => $lang, 'parent'=> 0));

        $items->order('sort','ASC')->order('id','ASC');
        return $items->toJSON();
    }
}

