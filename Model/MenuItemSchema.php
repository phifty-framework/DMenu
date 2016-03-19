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
            ->required(true)
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
            ->default(function() { return 'link'; })
            ->validValues([
              '連結' => 'link',
              '選單' => 'folder',
              '頁面' => 'page',
              '產品類別' => 'dynamic:products',
              '最新消息' => 'dynamic:news',
            ])
            ;

        $this->column('require_login')
            ->boolean()
            ->default(false)
            ->label('須登入')
            ;

        $this->column('class_names')
            ->varchar(200)
            ->null()
            ->label('Class names')
            ;

        $this->column('extra_attrs')
            ->varchar(200)
            ->null()
            ->label('Extra Element Attributes')
            ;

        # item data
        $this->column('data')
            ->varchar(200)
            ->label('網址 (或參數)')
            ;

        $this->column('sort')
            ->unsigned()
            ->smallint()->default(0);

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');

        $this->belongsTo('parent', 'DMenu\\Model\\MenuItemSchema', 'id', 'parent_id');

        $this->many('children', 'DMenu\\Model\\MenuItemSchema', 'parent_id', 'id')
            ->onDelete('CASCADE');
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

