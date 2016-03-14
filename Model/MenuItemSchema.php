<?php
namespace DMenu\Model;
use LazyRecord\Schema\SchemaDeclare;

class MenuItemSchema extends SchemaDeclare 
{
    function schema()
    {
        $this->column('label')->varchar(128);  # label
        $this->column('title')->varchar(256);  # <a title="{{ titlle }}">

        $this->column('parent')
            ->integer()
            ->null()
            ->refer('DMenu\\Model\\MenuItemSchema')
            ;

        # type: can be 'link','page','folder','dynamic'
        $this->column('type')->varchar(20);

        # item data
        $this->column('data')->text();
        $this->column('sort')->integer()->default(0);

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');
    }

    function bootstrap($record)
    {
        $record->create(array( 
            'label' => 'Google',
            'lang' => 'en',
            'type' => 'link',
            'data' => 'http://google.com/',
        ));
    }
}

