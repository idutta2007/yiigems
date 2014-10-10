<?php

/**
 * Defaults for tooltip widget.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.tooltips
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class TooltipDefaults {
    static $contentSelectionMethod = "text";
    static $location = "bottom";
    static $effectName = "none";
    static $duration = 300;

    static $topPos = array( "my" => "left-50 bottom-10", "at" => "center top");
    static $bottomPos = array("my" =>  "left-50 top+10", "at" =>  "center bottom");
    static $leftPos =  array("my" =>  "right-12 top-20", "at" =>  "left center");
    static $rightPos = array("my" =>  "left+12 top-20", "at" =>  "right center");

    static $scenarios = array(
        "form" => array(
            "topPos" =>  array("my" =>  "left bottom-10", "at" =>  "left top"),
            "bottomPos" =>  array("my" =>  "left top+10", "at" =>  "left bottom"),
            "leftPos" =>  array("my" =>  "right-10 top", "at" =>  "right top"),
            "rightPos" =>  array("my" =>  "left+10 top", "at" =>  "left top")
        ),

        "link" => array(
            "topPos" =>  array("my" => "left-50 bottom-10", "at"=> "center top"),
            "bottomPos" =>  array("my"=> "left-50 top+10", "at"=> "center bottom"),
            "leftPos" =>  array("my"=> "right-12 top-20", "at"=> "left center"),
            "rightPos" =>  array("my"=> "left+12 top-20", "at"=> "right center")
        )
    );

    // These attributes are global for tooltips and are used to set tooltip background and border color
    static $backgroundColor;
    static $borderColor;
}
