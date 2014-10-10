<?php
/**
 * The default settings for IconButton as determined by skin class.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttons
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class IconButtonDefaults {
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
    public static $roundStyle = "round";
    public static $fontSize = "normal_font";
    public static $iconClass = null;
    public static $options = array();

    public static $scenarios = array(
        "basic" => array(
            'gradient' => null,
            'displayShadow'=>false,
        ),
        "minimal" => array(
            'gradient' => null,
            'displayShadow'=>false,
            'options'=> array( 'style' => "border-width:0px")
        ),
        'gridButton' => array(
            'gradient' => null,
            'displayShadow'=>false,
            'fontSize' => "font_size10",
            'options' => array( 'style' => "padding: 0em 0.3em")
        ),
    );
}
