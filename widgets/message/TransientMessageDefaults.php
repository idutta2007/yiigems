<?php

/**
 * Description of TransientMessageDefaults
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.message
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.logictowers.com/yiigems/license/
 */
class TransientMessageDefaults {
    public static $iconClass;
    public static $gradient;
    public static $roundStyle = "round";
    public static $displayShadow = true;
    public static $coloredShadow =  false;
    public static $shadowDirection = "bottom_right";
    public static $options = array( 'style' => 'display:none;');
    
    public static $scenarios = array(
        'info'=>array(
            'iconClass'=>'icon-info-sign',
            'gradient' => "aliceBlue5"
        ),
        'warning'=>array(
            'iconClass'=>'icon-warning-sign',
            'gradient' => "orange5"
        ),
        'error'=>array(
            'iconClass'=>'icon-exclamation-sign',
            'gradient' => "crimson6"
        ),
    );
}

?>
