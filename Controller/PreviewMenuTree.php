<?php
namespace DMenu\Controller;

use Phifty\Controller;
use DMenu\Model\MenuItemCollection;
use DMenu\MenuBuilder;

class PreviewMenuTree extends Controller
{
    function indexAction()
    {
        $lang = $this->request->param('lang');
        $builder = new MenuBuilder( $lang );
        if( kernel()->bundle('ProductBundle') ) {
            $builder->addExpander( 'products' , 'DMenu\\Expander\\ProductMenuExpander' );
        }
        if( kernel()->bundle('UseCaseBundle') ) {
            $builder->addExpander( 'usecases' , 'DMenu\\Expander\\UseCaseCategoryMenuExpander' );
        }
        return $builder->build();
    }
}

