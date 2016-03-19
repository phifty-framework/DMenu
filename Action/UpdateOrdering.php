<?php
namespace DMenu\Action;

use ActionKit;
use DMenu\Model\MenuItem;

class UpdateOrdering extends \ActionKit\Action
{
    public function run()
    {
        $orderingList = json_decode($this->arg('json'));
        $error = false;
        foreach ($orderingList as $orderingItem) {
            $item = new MenuItem();
            $item->find(intval($orderingItem->record));
            $ret = $item->update(['ordering' => $orderingItem->order]);
            if ($ret) {
                $error = true;
            }
        }
        if ($error) {
            return $this->error('選單順序更新失敗');
        }
        return $this->success( _('Menu order has been updated.') );
    }
}



