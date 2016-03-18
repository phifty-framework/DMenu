<?php
namespace DMenu;
use DMenu\Model\MenuItem;
use DMenu\Model\MenuItemCollection;
use DMenu\Renderer\DefaultRenderer;
use Phifty\YAML;
use Phifty\Logger;
use Exception;


/* class for building front-end menu html,
 * usage:

    $builder = new MenuBuilder;
    $builder->addExpander( 'products' , 'DMenu\Expander\ProductMenuExpander' ); # register dynamic menu expander
    $tree = $builder->getTree();
    $tree = $builder->expandItems($tree);
    $menuHtml = $builder->render($tree);


    $builder2 = new MenuBuilder;
    $builder2->setRenderer(new \DMenu\Renderer\FlatRenderer);
    $footerMenuHtml = $builder2->build();

 **/
class MenuBuilder 
{
    public $expanders = array();
    public $renderer;
    public $verbose;

    public function __construct($lang = null)
    {
        $this->lang = $lang ?: kernel()->locale->current();
    }

    public function addExpander( $id , $cb )
    {
        $this->expanders[ $id ] = $cb;
    }

    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
    }

    public function getRenderer()
    {
        if ( $this->renderer ) {
            return $this->renderer;
        }
        // we should use default renderer.
        return $this->renderer = new DefaultRenderer;
    }

    function buildTree( $parent = 0 )
    {
        // find top menu item first
        $data  = array();
        $items = new MenuItemCollection;
        $items->where( array('parent_id' => $parent , 'lang' => $this->lang ) );
        $items->orderBy('sort','asc')
            ->orderBy('id','asc');
        $array = $items->items();

        for( $i = 0 ; $i < count($array) ; $i++ ) {
            $item = $array[ $i ];
            if( $item->type == "folder" ) {
                $itemData = $item->toArray();
                $itemData['items'] = $this->buildTree( $item->id );
                $data[] = $itemData;
            } else {
                $data[] = $item->toArray();
            }
        }
        return $data;
    }

    /* default renderer */
    public function render($tree, $level = 0) 
    {
        return $this->getRenderer()->render( $tree, $level );
    }

    public function expandItems( $tree )
    {
        // find items need to be expanded.
        for( $i = 0; $i < count($tree) ; $i++ ) {
            $item = & $tree[ $i ];

            if( $item['type'] == "folder" && isset($item['items']) ) {
                $item['items'] = $this->expandItems( $item['items'] );
            }
            elseif( preg_match( '/^dynamic:(\w+)/i', $item['type'], $regs ) ) {
                $expanderType = $regs[1];
                if( ! $regs[1] )
                    throw new Exception("MenuItem {$item['type']} can't be expanded.");

                if( isset( $this->expanders[ $expanderType ] ) ) {
                    /* expand menu items */
                    $cb = $this->expanders[ $expanderType ];
                    if( function_exists($cb) ) {
                        $item = call_user_func($cb, $this, $item['data'] );
                    }
                    elseif( is_callable( $cb ) ) {
                        $item = $cb( $this, $item['data'] );
                    }
                    elseif( class_exists($cb,true) )  {
                        $expander = new $cb($this);
                        $item = $expander->expand($item);
                    }
                    else {
                        throw new Exception("DMenu expander $cb not found.");
                    }
                }
            }
        }
        return $tree;
    }

    public function getTree()
    {
        return $this->buildTree();
    }

    public function build()
    {
        $tree = $this->getTree();
        $tree = $this->expandItems( $tree );
        return $this->render( $tree );
    }

}
