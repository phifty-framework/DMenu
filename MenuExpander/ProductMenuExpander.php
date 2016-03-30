<?php
namespace DMenu\MenuExpander;
use ProductBundle\Model\Category;
use ProductBundle\Model\Product;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\ProductCollection;
use DMenu\MenuExpander\MenuExpander;
use DMenu\MenuBuilder;
use DMenu\Model\MenuItem;
use LazyRecord\BaseModel;

class ProductMenuExpander implements MenuExpander
{
    protected $builder;

    public $categorylinkFormat = '/product?category_id=%d';

    public $productlinkFormat = '/product?category_id=%d';

    public function __construct(MenuBuilder $builder)
    {
        $this->builder = $builder;
    }

    protected function getRootLabel(MenuItem $rootItem)
    {
        return $rootItem->label ?: _('Products');
    }

    protected function getRootLink(MenuItem $rootItem)
    {
        return '/product';
    }

    protected function createRootMenuItem(MenuItem $rootItem)
    {
        $parentArray = [
            'type'        => 'folder',
            'label'       => $this->getRootLabel($rootItem),
            'data'        => $this-.getRootLink($rootItem),
            'expander'    => $rootItem->expander,
            'items'       => [],
        ];
        return $parentArray;
    }

    protected function fetchChildrenRecords(BaseModel $record = null)
    {
        if ($record) {
            return $record->subcategories;
        }

        $locale = null;
        if ($this->builder) {
            $locale = $this->builder->getLocale();
        } else {
            $locale = kernel()->locale->current;
        }

        // query product categories and return the tree structure.
        $collection = new CategoryCollection;
        $collection->where()
            ->equal('lang', $locale)
            ->group()
                ->equal('parent_id', 0)
                ->or()->is('parent_id',NULL)
            ->ungroup()
            ;
        $collection->orderBy('updated_on','desc');
        return $collection;
    }

    protected function createFolder(BaseModel $record)
    {
        return [
            'type' => 'folder',
            'label' => $record->dataLabel(), # category name 
            'data'  => sprintf('/product?category_id=%d', $record->id),
            'items' = [],
        ];
    }

    protected function createLink(BaseModel $record)
    {
        return [
            'type' => 'link',
            'label' => $record->dataLabel(),
            'data'  => sprintf('/product?category_id=%d', $record->id),
        ];
    }

    protected function convertChildRecord(BaseModel $record = null)
    {
        $children = $this->fetchChildrenRecords($record);
        if ($children->size() > 0) {
            $menu = $this->createFolder($record);
            foreach ($children as $child) {
                $menu['items'][] = $this->convertChildRecord($child);
            }
            return $menu;
        }
        return $this->createLink($record);
    }

    public function expand(MenuItem $rootItem)
    {
        $parentMenuItem = $this->createRootMenuItem($rootItem);
        $collection = $this->fetchChildrenRecords(null);
        foreach ($collection as $record) {
            $menuItem = $this->convertChildRecord($record);
            $parentMenuItem['items'][] = $menuItem;
        }
        return $parentMenuItem;
    }
}
