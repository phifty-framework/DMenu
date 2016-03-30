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

abstract class RecordMenuExpander implements MenuExpander
{
    /**
     * @var DMenu\MenuBuilder
     */
    protected $builder;


    /**
     * @var string link format
     */
    protected $linkFormat = '#{recordId}';

    protected $rootLink = '#rootItem';

    public function __construct(MenuBuilder $builder)
    {
        $this->builder = $builder;
    }

    protected function getRootLabel(MenuItem $rootItem)
    {
        return $rootItem->dataLabel();
    }

    protected function getRootLink(MenuItem $rootItem)
    {
        return $this->rootLink;
    }

    protected function createRootMenuItem(MenuItem $rootItem)
    {
        return [
            'type'        => 'folder',
            'label'       => $this->getRootLabel($rootItem),
            'data'        => $this->getRootLink($rootItem),
            'expander'    => $rootItem->expander,
            'items'       => [],
        ];
    }

    abstract protected function fetchRootCollection(MenuItem $rootItem);

    abstract protected function fetchChildrenRecords(BaseModel $record);

    protected function createFolder(BaseModel $record)
    {
        return [
            'type' => 'folder',
            'label' => $this->formatLabel($record),
            'data'  => $this->formatLink($record),
            'items' => [],
        ];
    }

    protected function createLink(BaseModel $record)
    {
        return [
            'type' => 'link',
            'label' => $this->formatLabel($record),
            'data'  => $this->formatLink($record),
        ];
    }

    protected function formatLabel(BaseModel $record)
    {
        return $record->dataLabel();
    }

    protected function formatLink(BaseModel $record)
    {
        return str_replace('{recordId}', $record->id, $this->linkFormat);
    }

    protected function convertChildRecord(BaseModel $record)
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
        $collection = $this->fetchRootCollection($rootItem);
        foreach ($collection as $record) {
            $menuItem = $this->convertChildRecord($record);
            $parentMenuItem['items'][] = $menuItem;
        }
        return $parentMenuItem;
    }
}