<?php
namespace DMenu\Renderer;
use DMenu\RendererInterface;
use Exception;

class SiteMapRenderer extends DefaultRenderer implements RendererInterface
{

    public function renderFolder($item, $level = 0) {
        $html = '';
        if( ! empty($item['items']) && is_array($item['items']) ) {
            foreach( $item['items'] as $subitem ) {
                $html .= $this->renderLink($subitem);
            }
        }
        return $html;
    }

    public function render($tree, $level = 0)
    {
        /*
        <div class="block sitemap-block">
            <h2 class="sitemap-title">關於我們</h2>
            <ul class="sitemap-list">
                <li>
                    <ul class="sitemap-sublist">
                        <li><a href="about_us.html">團隊介紹</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        */
        $html = '';
        $html .= str_repeat( ' ' , $level * 4 );
        $html .= "\n";
        foreach( $tree as $item ) {
            $html .= '<div class="block sitemap-block">';
            $html .= '<h2 class="sitemap-title">' . $item['label'] . '</h2>';
            $html .= '<ul class="sitemap-list">';
            if( $item['type'] == "folder" && isset($item['items']) ) {
                $html .= $this->renderFolder($item);
            } else {
                $html .= $this->renderLink($item);
            }
            $html .= '</ul>';
            $html .= '</div>';
        }
        $html .= str_repeat( ' ' , $level * 4 );
        $html .= "\n";
        return $html;
    }

}


