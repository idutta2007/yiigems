<?php

/**
 * The skin class for Title widget.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.title
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class TitleBarDefaults {
    public static $containerTag = "h3";
    public static $gradient = null;
    public static $displayShadow = true;
    public static $shadowDirection = "bottom";
    public static $fontSize = "normal_font";
    public static $roundStyle = "small_round_top";
    public static $coloredShadow = false;
    public static $leftIconClass = null;
    public static $rightIconClass = null;
    public static $options = array();

    public static $scenarios = array(
        'formSectionTitle'=>array(
            'leftIconClass' => "icon-circle-arrow-right pull-left",
            'displayShadow' => false,
        ),
        'pageSection'=>array(
            'roundStyle' => "round_left",
            'leftIconClass' => "icon-circle-arrow-right pull-left",
            'fontSize' => "font_size16",
            'options' => array( 'style' => "text-align:center;padding:0.75ex 1ex" )
        )
    );
}

?>
