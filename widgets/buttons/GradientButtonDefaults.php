<?php

/**
 * The skin class for GradientButton widget.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttons
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class GradientButtonDefaults {
    public static $htmlTag = "a";
    public static $gradient = null;
    public static $hoverGradient = null;
    public static $activeGradient = null;
    public static $selectedGradient = null;
    public static $displayShadow = true;
    public static $shadowDirection = "bottom_right";
    public static $coloredShadow = false;
    public static $borderStyle = "outset";
    public static $hoverBorderStyle = "outset";
    public static $activeBorderStyle = "inset";
    public static $selectedBorderStyle = "inset";
    public static $roundStyle = "small_round";
    public static $fontSize = "normal_font";
    public static $iconClass = null;
    public static $options = array();
    
    public static $scenarios = array(
        "action" => array(
            'gradient' =>'dodgerBlue6'
        ),
        "danger" => array(
            'gradient' =>'crimson5'
        ),
        "success" => array(
            'gradient' =>'forestGreen6'
        ),
        "info" => array(
            'gradient' =>'crimson5'
        ),
        "inverse" => array(
            'gradient' =>'gray8'
        ),
    );
}
?>
