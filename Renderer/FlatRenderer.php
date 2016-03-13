<?php
namespace DMenu\Renderer;

use DMenu\RendererInterface;

class FlatRenderer implements RendererInterface
{
    function render($tree,$level = 0) 
    {
        $html = '';
        $cnt = 0;
        foreach( $tree as $item ) {
            if( $item['type'] == "folder" && isset($item['items']) ) {
                $html .= str_repeat( ' ' , $level * 4 );

                if( isset($item['data']) )
                    $html .= sprintf('<a href="%s">%s</a>', $item['data'], $item['label']);
                else
                    $html .= sprintf('<a href="#">%s</a>', $item['label']);
            }
            else {
                $html .= sprintf('<a href="%s">%s</a>', @$item['data'] , $item['label'] ) . "\n";
                # $html .= '<li><a href="#"><span>'.$item['label']."</span></a></li>\n";
            }

            if( ++$cnt < count($tree) )
                $html .= ' | ';
        }
        return $html;
    }

}


