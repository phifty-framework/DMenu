<?php
namespace DMenu\Model;
use DMenu\Model\MenuItemBase;
use PageBundle\Model\Page;

class MenuItem extends MenuItemBase
{

    function getLabel()
    {
        return _('Menu Item');
    }

    function beforeDelete($args)
    {
        $items = new MenuItemCollection;
        $items->where( array( 'parent' => $this->id ) );
        $items->delete();
    }

    function beforeCreate($args) 
    {
        if( isset($args['type']) && $args['type'] == "page" ) {
            // include the page
            $page = new Page((int) $args['data']);
            if( $page->id )
                $args['label'] = $page->title;
            else
                return;
        }
        return $args;
    }

    function beforeUpdate($args)
    {
        if( $this->type == "page" && isset($args['data']) ) {
            // include the page
            $page = new Page((int) $args['data']);
            if ( $page->id ) {
                $args['label'] = $page->title;
            } else {
                return $args;
            }
        }
        return $args;
    }
    
}
