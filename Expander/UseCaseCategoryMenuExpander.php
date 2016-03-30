<?php
namespace DMenu\Expander;
use UseCaseBundle\Model\CategoryCollection;
use DMenu\MenuExpanderInterface;
use DMenu\MenuExpander\MenuExpander;

/* build product menu */
class UseCaseCategoryMenuExpander implements MenuExpander
{
    public $builder;

    public function __construct($builder = null)
    {
        $this->builder = $builder;
    }

    public function getCollection($lang)
    {
        $cates = new CategoryCollection;
        $cates->where()
            ->equal('lang', $lang)
            /*
            ->group()
                ->equal('parent_id',0)
                ->or()->is('parent_id','null')
            ->ungroup()
             */
            ;
        $cates->order('created_on','desc');
        return $cates;
    }

    public function getLang() {
        if ( $this->builder ) {
            return $this->builder->lang;
        } else {
            return kernel()->locale->current();
        }
    }

    public function expand($item)
    {
        $lang = $this->getLang();

        // query product categories and return the tree structure.
        $cates = $this->getCollection($lang);
        $label = isset( $item['label'] ) ?
                        _($item['label']) : _('UseCase');
        $menuItems = array(
            'type' => 'folder',
            'label' => $label,
            'data' => '#usecase',
            'expand_from' => $item['type'],
        );

        foreach( $cates as $c )
        {
            /* virtual category items */
            $categoryMenuItem = array( 
                'type' => 'folder',
                'label' => $c->name, # category name
                'data'  => sprintf('/usecase/%d/%s',$c->id, urlencode($c->name)),
                // 'items' => array()
            );

            /*
            $subcates = new CategoryCollection;
            $subcates->where(array( 'parent_id' => $c->id ));
            foreach( $subcates as $subcate ) {
                $categoryMenuItem['items'][] = array(
                    'type' => 'link',
                    'label' => $subcate->name,
                    'data'  => sprintf('/usecase?category_id=%d', $subcate->id),
                );
            }
            */
            $menuItems['items'][] = $categoryMenuItem;
        }
        return $menuItems;
    }
}
