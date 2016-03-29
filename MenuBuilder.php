<?php
namespace DMenu;
use DMenu\Model\MenuItem;
use DMenu\Model\MenuItemCollection;
use DMenu\Renderer\DefaultRenderer;
use Phifty\YAML;
use Phifty\Logger;
use Phifty\Security\CurrentUser;
use Exception;


/* class for building front-end menu html,
 * usage:

    $builder = new MenuBuilder;
    $builder->addExpander( 'products' , 'DMenu\Expander\ProductMenuExpander' ); # register dynamic menu expander
    $tree = $builder->getTree();
    $tree = $builder->expandTree($tree);

    $builder2 = new MenuBuilder;
    $builder2->setRenderer(new \DMenu\Renderer\FlatRenderer);
    $footerMenuHtml = $builder2->build();

 **/
class MenuBuilder
{
    protected $expanders = array();

    public function __construct($lang = null)
    {
        $this->lang = $lang;
    }

    public function addExpander($expanderId , $cb )
    {
        $this->expanders[$expanderId] = $cb;
    }

    /**
     * buildTree converts model objects into a plain array list
     *
     * @return array[]
     */
    public function buildTree($parent, CurrentUser $currentUser = null)
    {
        // find top menu item first
        $items = new MenuItemCollection;
        $items->where()
                ->equal('parent_id', $parent)
            ->equal('lang', $this->lang);
        $items->orderBy('sort','ASC')
            ->orderBy('id','ASC');

        $data = [];
        foreach ($items as $item) {
            if ($item->require_login) {
                if (!$currentUser->hasLoggedIn()) {
                    continue;
                }
            }
            if ($item->is_hidden) {
                continue;
            }

            if ($item->type === "folder" || $item->children->size() > 0) {
                $itemData = $item->toArray();
                $itemData['items'] = $this->buildTree($item->id, $currentUser);
                $data[] = $itemData;
            } else {
                $data[] = $item->toArray();
            }
        }
        return $data;
    }

    protected function expandTree(array $tree, CurrentUser $currentUser = null)
    {
        // find items need to be expanded.
        for( $i = 0; $i < count($tree) ; $i++ ) {
            $item = & $tree[ $i ];
            if( $item['type'] == "folder" && isset($item['items']) ) {
                $item['items'] = $this->expandTree($item['items'], $currentUser);
            } else if( preg_match( '/^dynamic:(\w+)/i', $item['type'], $regs ) ) {
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

    public function build(CurrentUser $currentUser = null)
    {
        // build a basic menu tree and expand the tree with expander
        $tree = $this->buildTree(0, $currentUser);
        return $this->expandTree($tree, $currentUser);
    }

}
