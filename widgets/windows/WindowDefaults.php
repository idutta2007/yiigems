<?php
/**
 * Description of WindowDefaults
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.windows
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */
class WindowDefaults {
    // TODO - copy from skin
    public static $containerTag = "div";
    public static $containerOptions = array();
    public static $roundStyle = "round";
    public static $displayShadow = true;
    public static $shadowDirection = "bottom_right";
    public static $coloredShadow =  false;


    public static $titleTag = "div";
    public static $titleOptions = array( 'style'=> "position:relative" );
    public static $titleFontSize;
    public static $titleGradient = "glassyGray5";
    public static $titleText = "<span style='color:red'>[Title Not Set]</span>";
    public static $titleLeftIconClass = "icon-glass pull-left";
    public static $titleRightIconClass = "icon-remove pull-right dialog-close-button";

    public static $scenarios = array();
}

?>
