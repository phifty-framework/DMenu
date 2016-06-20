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

        $this->column('is_hidden')
            ->boolean()
            ->default(false)
            ->label('隱藏')
            ->renderAs('CheckboxInput');
            ;

        $this->column('parent_id')
            ->integer()
            ->unsigned()
            ->default(0)
            ->label('上層選單')
            ->renderAs('SelectInput', [
                'allow_empty' => 0,
            ])
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
                '動態' => 'dynamic',
            ])
            ;

        $this->column('expander')
            ->varchar(60)
            ->label('展開器')
            /*
            ->validValues([
                '展開為產品類別' => 'product_categories',
                '展開為最新消息' => 'news',
            ])
            ->renderAs('SelectInput', [ 'allow_empty' => true ])
            */
            ->renderAs('TextInput')
            ;

        $this->column('require_login')
            ->boolean()
            ->default(false)
            ->label('須登入')
            ->renderAs('CheckboxInput');
            ;

        $this->column('handle')
            ->varchar(30)
            ->unique()
            ->label('Handle')
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

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');
        $this->mixin('SortablePlugin\\Model\\Mixin\\OrderingSchema');

        $this->belongsTo('parent', 'DMenu\\Model\\MenuItemSchema', 'id', 'parent_id');

        $this->many('children', 'DMenu\\Model\\MenuItemSchema', 'parent_id', 'id')
            ->onDelete('CASCADE');
    }
}
