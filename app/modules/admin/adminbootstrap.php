<?php
class AdminBootstrap extends Bwork_Bootstrap_AbstractBootstrap
{
    public function _initLayout()
    {
        $layout = new Bwork_Layout_Default();
        $layout->setLayout('layout.php', 'admin');

        return new Bwork_Bootstrap_Alias('Bwork_Layout_Layout', $layout, Bwork_Core_Registry::OVERRIDING);
    }
}