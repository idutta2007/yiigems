<?php

/**
 * The skin class for JupiterDropdownMenu widget.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.dropdown
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class JupiterDropdownMenuDefaults {
    public static $menuTag = "ul";
    public static $itemTag = "li";
    
    public static $menuGradient;
    public static $dropMenuGradient;
    public static $flyMenuGradient;
    public static $menuItemHoverGradient;
    public static $dropMenuItemHoverGradient;
    public static $flyMenuItemHoverGradient;
    
    public static $displayShadow = true;
    public static $shadowDirection = "bottom_right";
    public static $coloredShadow = false;
    
    public static $menuRoundStyle = "big_round";
    public static $menuItemRoundStyle = "big_round";
    public static $dropMenuRoundStyle = "big_round";
    public static $dropMenuItemRoundStyle = "big_round";
    public static $flyMenuRoundStyle = "big_round";
    public static $flyMenuItemRoundStyle = "big_round";
    
    public static $fontSize = "font_size12";
    
    public static $menuOptions = array();
    public static $dropMenuOptions = array();
    public static $flyMenuOptions = array();
    
    public static $menuItemOptions = array();
    public static $dropMenuItemOptions = array();
    public static $flyMenuItemOptions = array();
    
    public static $menuAnchorOptions = array();
    public static $dropMenuAnchorOptions = array();
    public static $flyMenuAnchorOptions = array();
    
    public static $searchTextOptions = array(
        'class'=>'big_round',
        'style'=>'font-size:inherit;height:2.5em;outline-style:none;border:0px;padding:0em 1em'
    );
}
?>
