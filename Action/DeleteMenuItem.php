<?php
namespace DMenu\Action;

use ActionKit\Action;
use ActionKit\RecordAction\BaseRecordAction;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteMenuItem  extends DeleteRecordAction {


    public $recordClass = 'DMenu\\Model\\MenuItem';

    public function run()
    {
        $record = $this->getRecord();
        $children = $record->children;
        if ($children->size() > 0) {
            $children->delete();
        }
        return parent::run();
    }

}




