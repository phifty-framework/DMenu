<?php
namespace DMenu\Model;
use LazyRecord\Schema\SchemaDeclare;

class MenuItemSchema extends SchemaDeclare
{
    public function schema()
    {
        $this->column('label')
            ->varchar(128)
            ->label('標籤')
            ;  # label
        $this->column('title')
            ->varchar(256)
            ->label('標題')
            ;  # <a title="{{ titlle }}">

        $this->column('parent_id')
            ->integer()
            ->unsigned()
            ->null()
            // ->refer('DMenu\\Model\\MenuItemSchema')
            ->label('上層選項')
            ->renderAs('SelectInput', [ 'allow_empty' => true ])
            ;

        # type: can be 'link','page','folder','dynamic'
        $this->column('type')
            ->varchar(20)
            ->required()
            ->label('類型')
            ;

        # item data
        $this->column('data')->text();
        $this->column('sort')->integer()->default(0);

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');

        $this->belongsTo('parent', 'DMenu\\Model\\MenuItemSchema', 'id', 'parent_id');
    }

    public function bootstrap($record)
    {
        $record->create(array(
            'label' => 'Google',
            'lang' => 'en',
            'type' => 'link',
            'data' => 'http://google.com/',
        ));
    }
}

