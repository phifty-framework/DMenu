<?php
namespace DMenu\Renderer;
use DMenu\RendererInterface;
use Phifty\Security\CurrentUser;
use WebUI\Core\Element;

/**
Render menu items to HTML

the link item contains:

    $item = [
        'type'  => 'link',
        'label' => _('New Products'),
        'data'  => '/new_products',
        'attrs' => [],
    ];

 */
class DefaultRenderer
{
    protected $ulClasses = array();

    protected $sharedAttributes;

    public function addClass()
    {
        $this->ulClasses = array_merge($this->ulClasses,func_get_args());
    }

    public function setSharedAttributes(array $attributes)
    {
        $this->sharedAttributes = $attributes;
    }

    protected function renderItem(array $item, $level = 0)
    {
        $attributes = ['href' => $item['data'] ?: '#'];

        // shared attributes
        if ($this->sharedAttributes) {
            $attributes = array_merge($this->sharedAttributes, $attributes);
        }

        // per-item attributes
        if (isset($item['attrs'])) {
            $attributes = array_merge($attributes, (array) $item['attrs']);
        }
        $a = new Element('a', $attributes);
        if (isset($item['extra_attrs'])) {
            $a->setExtraAttributeString($item['extra_attrs']);
        }
        $a->append($item['label']);

        $li = new Element('li');
        $li->append($a);
        if (isset($item['items']) && is_array($item['items']) ) {
            $ul = $this->render($item['items'], $level + 1);
            $li->append($ul);
        }
        return $li;
    }

    public function render(array $tree, $level = 0)
    {
        $ul = new Element('ul', $level == 0 ? ['class' => $this->ulClasses ] : []);
        foreach ($tree as $item) {
            $li = $this->renderItem($item, $level);
            $ul->append($li);
        }
        return $ul;
    }
}


