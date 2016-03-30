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

class ProductMenuExpander extends RecordMenuExpander implements MenuExpander
{
    protected $builder;

    protected $linkFormat = '/product?category_id={recordId}';

    protected $rootLink = '/product';

    protected function getRootLabel(MenuItem $rootItem)
    {
        return $rootItem->label ?: _('Products');
    }

    protected function fetchRootCollection(MenuItem $rootItem)
    {
        $locale = $this->builder ? $this->builder->getLocale() : kernel()->locale->current;
        $collection = new CategoryCollection;
        $collection->where()
            ->equal('lang', $locale)
            ->group()
                ->equal('parent_id', 0)
                ->or()->is('parent_id',NULL)
            ->endgroup()
            ;
        $collection->orderBy('updated_on','desc');
        return $collection;
    }

    protected function fetchChildrenRecords(BaseModel $record)
    {
        return $record->subcategories;
    }

}
