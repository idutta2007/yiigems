<?php
/**
 * The skin class for TitleHeader widget.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.titleBox
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class TitleBoxDefaults {
    static $containerTag = "div";
    static $titleTag = "h3";
    static $contentTag = "div";
    
    static $containerRoundStyle="small_round";
    static $containerOptions=array();
    
    static $headerGradient = "aliceBlue6";
    static $headerRoundStyle="small_round_top";
    static $headerFontSize="normal_font";
    static $headerOptions=array();
    
    static $contentGradient;
    static $contentRoundStyle = "small_round_bottom";
    static $contentFontSize="normalFont";
    static $contentOptions=array( "style"=>"border-style:solid;border-width:0.2em");
    
    static $displayShadow = true;
    static $shadowDirection = "bottom_right";
    static $coloredShadow = false;

    public static $leftIconClass = null;
    public static $rightIconClass = null;
    public static $collapsible = null;
    public static $collapseIconClass = "icon-collapse-alt";
    public static $expandIconClass = "icon-expand-alt";

    public static $scenarios = array();
}
?>
