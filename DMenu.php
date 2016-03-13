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
        $this->route( '/dmenu/menu_form' ,          'MenuForm' );
        $this->route( '/dmenu/preview_menu_tree' ,  'PreviewMenuTree' );
        $this->route( '/dmenu/api/get_menu_items' , 'GetMenuItems' );
        $this->route( '/dmenu/api/get_menu_tree'  , 'GetMenuTree' );
        $this->route( '/bs/dmenu' ,                 'Panel' );
        $this->route( '/bs/dmenu/region' ,                 'Panel:regionAction');

        $this->addRecordAction( 'MenuItem' ,         array( 'Create','Update','Delete') );


        $self = $this;
        kernel()->event->register( 'adminui.init_menu' , function($menu) use ($self) {
            $menu->createMenuItem( _('Menu') , array( 
                'href' => '/bs/dmenu',
                'region' => array('path' => '/bs/dmenu/region'),
            ));
        });
    }
}
