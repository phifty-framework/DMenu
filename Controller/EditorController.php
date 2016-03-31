<?php
namespace DMenu\Controller;
use Phifty\Controller;
use AdminUI\Controller\BaseController;

class EditorController extends BaseController
{
    public function indexAction()
    {
        return $this->render('@DMenu/editor.html');
    }

    public function regionAction()
    {
        return $this->render('@DMenu/editor_region.html');
    }
}

