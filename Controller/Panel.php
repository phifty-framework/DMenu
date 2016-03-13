<?php
namespace DMenu\Controller;
use Phifty\Controller;

class Panel extends \AdminUI\Controller\Panel
{
    public function indexAction()
    {
        return $this->view()->render('@DMenu/dmenu_panel.html');
    }

    public function regionAction()
    {
        return $this->view()->render('@DMenu/dmenu_panel_region.html');
    }
}

