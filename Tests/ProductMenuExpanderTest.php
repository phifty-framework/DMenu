<?php
use DMenu\Renderer\SuperfishRenderer;
use DMenu\MenuBuilder;
use DMenu\Model\MenuItem;
use MemberBundle\CurrentMember;

class ProductMenuExpanderTest extends PHPUnit_Framework_TestCase
{
    public function testProductMenuItemExpander()
    {
        $menuItem = new MenuItem;
        $ret = $menuItem->createOrUpdate([
            'label' => 'Testing Product Categories',
            'type' => 'dynamic',
            'expander' => 'product_categories',
            'lang' => 'zh_TW',
            'parent_id' => 0,
        ], 'expander');
        $this->assertTrue($ret->success);

        $menuBuilder = new MenuBuilder('zh_TW' ?: $this->kernel->locale->current());
        $menuBuilder->addExpander('product_categories', 'DMenu\\MenuExpander\\ProductMenuExpander');

        $menuTree = $menuBuilder->build(new CurrentMember);
        $this->assertNotEmpty($menuTree);

        $menuRenderer = new SuperfishRenderer;
        $menuHtml = $menuRenderer->render($menuTree);
        echo $menuHtml;
    }
}
