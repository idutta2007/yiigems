<?php

/**
 * An widget to display sidebar menu on the left hand side of a web page.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.sidebarMenu
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */


Yii::import("ext.yiigems.widgets.sidebarMenu.AbstractSidebarMenu");
Yii::import("ext.yiigems.widgets.sidebarMenu.LeftSidebarMenuDefaults");

class LeftSidebarMenu extends AbstractSidebarMenu {

    /**
     * @var string the CSS class for the container element.
     */
    public $navClass = "leftSidebarMenu";

    /**
     * @var string the primary CSS file used by this widget.
     */
    public $cssFile = "leftSidebarMenu.css";

    public $skinClass = "LeftSidebarMenuDefaults";

    /**
     * Sets the properties of the menu to default values from current skin.
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("lsbm-");
    }
}

?>
