<?php

/**
 * An widget to display sidebar menu on the right hand side of a web page.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.sidebarMenu
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.sidebarMenu.AbstractSidebarMenu");
Yii::import("ext.yiigems.widgets.sidebarMenu.RightSidebarMenuDefaults");

class RightSidebarMenu extends AbstractSidebarMenu {
    /**
     * @var string the CSS class for the container element.
     */
    public $navClass = "rightSideBar";

    /**
     * @var string the primary CSS file used by this widget.
     */
    public $cssFile = "rightSidebarMenu.css";

    public $skinClass = "RightSidebarMenuDefaults";
    
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("rsbm-");

    }
}

?>
