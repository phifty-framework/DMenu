<?php
namespace DMenu\Expander;
use ProductBundle\Model\Category;
use ProductBundle\Model\Product;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\ProductCollection;
use DMenu\MenuExpanderInterface;

/* build product menu */
class ProductMenuExpander 
    implements MenuExpanderInterface 
{
    public $builder;
    public $categorylinkFormat = '/product?category_id=%d';
    public $productlinkFormat = '/product?category_id=%d';

    public function __construct($builder = null)
    {
        $this->builder = $builder;
    }

    public function expand($item) 
    {
        $lang = null;
        if( $this->builder )
            $lang = $this->builder->lang;
        else
            $lang = kernel()->locale->current;

        // query product categories and return the tree structure.
        $cates = new CategoryCollection;
        // if( isset($item['lang'] ) )
        //     $cates->where(array('lang' => $item['lang'] , 'parent_id' => 0 ));
        $label = isset( $item['label'] ) ?
                        $item['label'] : _('Products');
        $cates->where()
            ->equal('lang', $lang)
            ->group()
                ->equal('parent_id',0)
                ->or()->is('parent_id','null')
            ->ungroup()
            ;
        $cates->order('updated_on','desc');

        $productMenuItem = array(
            'type' => 'folder',
            'label' => $label,
            'data' => '/product',
            'expand_from' => $item['type'],
        );

        foreach( $cates as $c )
        {
            /* virtual category items */
            $categoryMenuItem = array( 
                'type' => 'folder',
                'label' => $c->name, # category name 
                'data'  => sprintf('/product?category_id=%d',$c->id ),
                // 'items' => array()
            );

            $subcates = new CategoryCollection;
            $subcates->where(array( 'parent_id' => $c->id ));
            foreach( $subcates->items() as $subcate ) {
                $categoryMenuItem['items'][] = array(
                    'type' => 'link',
                    'label' => $subcate->name,
                    'data'  => sprintf('/product?category_id=%d', $subcate->id),
                );
            }
            $productMenuItem['items'][] = $categoryMenuItem;
        }
        return $productMenuItem;
    }
}
