<?php
namespace DMenu\Action;

use ActionKit;
use DMenu\Model\MenuItem;

class UpdateOrdering extends \ActionKit\Action
{
    function run()
    {
        $orderingList = json_decode($this->arg('json'));
        foreach( $orderingList as $ordering ) {
            $item = new MenuItem( (int) $ordering->record );
            $item->update(array( 'sort' => $ordering->order ));
        }
        return $this->success( _('Menu Ordering has been updated.') );
    }
}



