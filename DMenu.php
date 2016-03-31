<?php
namespace DMenu;
use Phifty\Bundle;
use DMenu\Model\MenuItemCollection;
use DMenu\Model\MenuItem;

class DMenu extends \Phifty\Bundle 
{
    public function assets()
    {
        return array('phifty-dmenu');
    }

    public function init()
    {
        $this->route( '/dmenu/preview-menu-tree' ,  'PreviewMenuTree' );
        $this->route( '/=/dmenu/tree'  , 'GetMenuTree');

        $this->route('/bs/dmenu', 'EditorController:index');
        $this->route('/bs/dmenu/crud/index', 'EditorController:region');

        $this->mount('/bs/menu_item','MenuItemCRUDHandler');
        $this->addRecordAction('MenuItem');
    }
}
