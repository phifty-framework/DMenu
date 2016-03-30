<?php
namespace DMenu\MenuExpander;
use DMenu\Model\MenuItem;

interface MenuExpander
{ 
    public function expand(MenuItem $item);
}


