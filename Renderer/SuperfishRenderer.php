<?php
namespace DMenu\Renderer;

use DMenu\RendererInterface;

class SuperfishRenderer extends DefaultRenderer implements RendererInterface
{
    public $ulClasses = array('sf-menu');

    public function render($tree,$level = 0) 
    {
        $html = '';
        $html .= str_repeat( ' ' , $level * 4 );

        if( $level == 0 ) {
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


