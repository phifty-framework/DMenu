<?php

namespace DMenu\Controller;

use Phifty\Controller;
use DMenu\Model\MenuItem;
use PageBundle\Model\Page;
use PageBundle\Model\PageCollection;

class MenuForm extends Controller
{
    public function indexAction()
    {
        $id     = $this->request->param('id');
        $type   = $this->request->param('type');
        $lang   = $this->request->param('lang');
        $data   = array();
        $item   = null;

        if( $id ) {
            // it's updating
            $item = new MenuItem( (int) $id );
            if( ! $item->id )
                return $this->renderJson(array('error'=> 'Can not load item.'));
            $data = $item->getData();
            $type = $item->type;
        } else {
            // it's creating
            $data['parent'] = $this->request->param('parent');
            $data['type']   = $type;
            if( $lang )
                $data['lang']   = $lang;
        }

        if( ! $type )
            return $this->forbidden( 'Type is required.' );

        switch($type) {
        case 'link':
        case 'folder':
            return $this->render("@DMenu/form_$type.html", array( 
                'id'     => $id,
                'item'   => $item,
                'data'   => $data,
            ));
            break;
        case 'page':
            # query pages
            $pages = new \PageBundle\Model\PageCollection;
            return $this->render("@DMenu/form_$type.html", array( 
                'id'     => $id,
                'item'   => $item,
                'data'   => $data,
                'pages'  => $pages->items(),
            ));
            break;
        default:
            if( strpos($type,'dynamic:') === 0 ) {
                return $this->render("@DMenu/form_dynamic.html", array( 
                    'id'     => $id,
                    'item'   => $item,
                    'data'   => $data,
                ));
            }
            break;
        }
        return $this->forbidden();
    }
}

