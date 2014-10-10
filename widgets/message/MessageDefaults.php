<?php

/**
 * MessageDefaults class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.message
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class MessageDefaults {
    public static $headerText;
    public static $headerIconClass;
    public static $gradient;
    public static $fontSize;
    public static $roundStyle = "small_round";
    public static $displayShadow = false;
    public static $coloredShadow = false;
    public static $shadowDirection = "bottom_right";
    public static $allowClose = true;
    public static $bodyNull = false;
    public static $headerOptions= array();
    public static $containerOptions= array();
    
    public static $scenarios = array(
        'info'=>array(
            'headerText'=>'Information',
            'headerIconClass'=>'icon-info-sign',
            'gradient' => "aliceBlue1"
        ),
        'info-single-line'=>array(
            'headerText'=>'Information Single Line',
            'headerIconClass'=>'icon-info-sign',
            'headerOptions' => array('style'=>'font-size:16px'),
            'bodyNull' => true,
            'gradient' => "aliceBlue1",
            'displayShadow' => false
        ),
        'warning'=>array(
            'headerText'=>'Warning!',
            'headerIconClass'=>'icon-warning-sign',
            'gradient' => "orange1"
        ),
        'warning-single-line'=>array(
            'headerText'=>'Warning!',
            'headerIconClass'=>'icon-warning-sign',
            'headerOptions' => array('style'=>'font-size:16px; color:black'),
            'bodyNull' => true,
            'gradient' => "orange1",
            'displayShadow' => false
        ),
        'error'=>array(
            'headerText'=>'Error!',
            'headerIconClass'=>'icon-exclamation-sign',
            'gradient' => "crimson6"
        ),
        'error-single-line'=>array(
            'headerText'=>'Error!',
            'headerIconClass'=>'icon-exclamation-sign',
            'headerOptions' => array('style'=>'font-size:16px'),
            'bodyNull' => true,
            'gradient' => "crimson6",
            'displayShadow' => false
        ),
        'success'=>array(
            'headerText'=>'Success!',
            'headerIconClass'=>'icon-thumbs-up',
            'gradient' => "seaGreen2"
        ),
        'failure'=>array(
            'headerText'=>'Failed!',
            'headerIconClass'=>'icon-thumbs-down',
            'gradient' => "red7"
        ),
        'systemAlert'=>array(
            'headerText'=>'System Alert!',
            'headerIconClass'=>'icon-exclamation-sign',
            'gradient' => "gray8"
        ),
        'formNote'=>array(
            'headerText'=>null,
            'gradient' => "oliveDrab1",
            'allowClose' => false,
        ),
    );
}

?>
