<?php
namespace DMenu\Renderer;

use DMenu\RendererInterface;
use Phifty\Security\CurrentUser;


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
class DefaultRenderer implements RendererInterface
{
    public $ulClasses = array();

    public function addClass()
    {
        $this->ulClasses = array_merge($this->ulClasses,func_get_args());
    }

    public function _renderAttributes($item) {
        $attrs = array();
        if ( isset($item['attrs']) ) {
            foreach( $item['attrs'] as $key => $value ) {
                $attrs[] = sprintf('%s="%s"',$key, $value);
            }
            return ' ' . join(' ', $attrs);
        }
        return '';
    }

    public function renderLink($item, $close = true) {
        $html = '';
        if ( isset($item['data']) ) {
            $html .= sprintf('<li><a href="%s"%s>%s</a>', $item['data'], $this->_renderAttributes($item), $item['label']);
        } else if ( isset($item['label'] )) {
            $html .= sprintf('<li><a href="#"%s>%s</a>', $this->_renderAttributes($item), $item['label']);
        } else {
            throw new Exception("unsupported structure");
        }
        if ( $close ) {
            $html .= '</li>';
        }
        return $html;
    }

    public function renderFolder($item, $level = 0) {
        $html = str_repeat( ' ' , $level * 4 );
        $html .= $this->renderLink($item, false);
        if( ! empty($item['items']) && is_array($item['items']) ) {
            $html .= $this->render( $item['items'] , $level + 1 );
        }
        $html .= str_repeat( ' ' , $level * 4 );
        $html .= "</li>\n";
        return $html;
    }


    public function render($tree, $level = 0)
    {
        $html = '';
        $html .= str_repeat( ' ' , $level * 4 );

        if( $level == 0 && ! empty($this->ulClasses) ) {
            $html .= '<ul class="'. join(" ", $this->ulClasses) .'">'. "\n";
        } else {
            $html .= "<ul>\n";
        }

        foreach( $tree as $item ) {
            if( $item['type'] == "folder" && isset($item['items']) ) {
                $html .= $this->renderFolder($item);
            } else {
                $html .= $this->renderLink($item);
            }
        }
        $html .= str_repeat( ' ' , $level * 4 );
        $html .= "</ul>\n";
        return $html;
    }
}


