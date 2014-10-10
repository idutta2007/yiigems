<?php

/**
 * ColoredLabelDefaults class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.labels
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class ColoredLabelDefaults {
    public static $gradient;
    public static $backgroundColor;
    public static $textColor;
    public static $iconClass;
    public static $fontSize = "normal_font";
    public static $roundStyle = "small_round";
    public static $displayShadow = false;
    public static $coloredShadow = false;
    public static $shadowDirection = "bottom_right";
    public static $options = array();
    
    public static $scenarios = array(
        'info'=>array(
            'gradient'=>'aliceBlue5',
            'fontSize'=>'normal_font',
            'roundStyle'=>'small_round',
            'displayShadow'=>false
        ),
        'warning'=>array(
            'gradient'=>'yellow2',
            'fontSize'=>'normal_font',
            'roundStyle'=>'small_round',
            'displayShadow'=>false
        ),
        'error'=>array(
            'gradient'=>'red6',
            'fontSize'=>'normal_font',
            'roundStyle'=>'small_round',
            'displayShadow'=>false
        ),
        'success'=>array(
            'gradient'=>'oliveDrab5',
            'fontSize'=>'normal_font',
            'roundStyle'=>'small_round',
            'displayShadow'=>false
        ),
        'alert'=>array(
            'gradient'=>'gray7',
            'fontSize'=>'normal_font',
            '$roundStyle'=>'small_round',
            'displayShadow'=>false
        ),
        'inputGroup'=>array(
            'gradient'=>'gray6',
            'displayShadow'=>false,
        ),
    );
}

?>
