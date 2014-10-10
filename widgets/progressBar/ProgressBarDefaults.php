<?php

/**
 * ProgressBarDefaults class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.progressBar
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class ProgressBarDefaults {
    public static $containerColor;
    public static $containerGradient;
    public static $barColor;
    public static $barGradient;
    
    public static $containerRoundStyle = "big_round";
    public static $barRoundStyle = "big_round_left";
    
    public static $displayContainerShadow = true;
    public static $containerShadowDirection = "bottom_right";
    public static $displayColoredConatainerShadow = false;
    
    public static $displayBarShadow = false;
    public static $barShadowDirection = "bottom_right";
    public static $displayColoredBarShadow = false;
    
    public static $barHeight = "1.5em";
    public static $barWidth = "20%";
    
    public static $striped = true;
    public static $animated = true;
    
    public static $containerOptions = array('style'=>"padding:0.5em");
    public static $barOptions = array();
    
    public $scenarios = array(
        'small'=>array(
            'barHeight'=> "0.75em"
        ),
        
        'medium'=>array(
            'barHeight'=> "1em"
        ),
        
        'large'=>array(
            'barHeight'=> "2em"
        )
    );
}

?>
