<?php

/**
 * Description of DropdownButtonDefaults
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttons
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */
class DropdownButtonDefaults {
    public static $htmlTag = "a";
    public static $gradient = null;
    public static $hoverGradient = null;
    public static $activeGradient = null;
    public static $selectedGradient = null;
    public static $displayShadow = true;
    public static $shadowDirection;
    public static $coloredShadow = false;
    public static $borderStyle = "outset";
    public static $hoverBorderStyle = "outset";
    public static $activeBorderStyle = "inset";
    public static $selectedBorderStyle = "inset";
    public static $roundStyle = "small_round";
    public static $fontSize = "normal_font";
    public static $iconClass = null;
    public static $options = array();
    
    public static $dropdownContainerOptions =  array();
    public static $dropdownItemIconClass;
    public static $downIconClass = "icon-caret-down";
    public static $itemHoverBackground;
}

?>
