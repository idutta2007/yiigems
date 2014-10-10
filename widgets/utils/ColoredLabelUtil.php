<?php

/**
 * An utility class to create ColoredLabel widgets.
 *
 * Examples:
 * <pre>
 *
 *  ColoredLabelUtil::infolabel( "Some Label");
 *  ColoredLabelUtil::warninglabel( "This is a warning", array( 'fontSize'=>'font_size18'));
 *  ColoredLabelUtil::errorlabel( "This is an Error", array( 'fontSize'=>'font_size28'));
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class ColoredLabelUtil {

    /**
     * Creates a ColoredLabel with scenario set to "info".
     * @param $text the text which will be colored.
     * @param array $options options for the ColoredLabel widget.
     * @param bool $captureOutput whether output should be captured.
     * @return the markup for the colored label if $captureOutput id true, otherwise null.
     */
    public static function infoLabel($text, $options = array(), $captureOutput=false) {
        $options['labelText'] = $text;
        $options['scenario'] = "info";
        return self::label($options, $captureOutput);
    }

    /**
     * Creates a ColoredLabel with scenario set to "warning".
     * @param $text the text which will be colored.
     * @param array $options options for the ColoredLabel widget.
     * @param bool $captureOutput whether output should be captured.
     * @return the markup for the colored label if $captureOutput id true, otherwise null.
     */
    public static function warningLabel($text, $options = array(), $captureOutput=false) {
        $options['labelText'] = $text;
        $options['scenario'] = "warning";
        return self::label($options, $captureOutput);
    }

    /**
     * Creates a ColoredLabel with scenario set to "error".
     * @param $text the text which will be colored.
     * @param array $options options for the ColoredLabel widget.
     * @param bool $captureOutput whether output should be captured.
     * @return the markup for the colored label if $captureOutput id true, otherwise null.
     */
    public static function errorLabel($text, $options = array(), $captureOutput=false) {
        $options['labelText'] = $text;
        $options['scenario'] = "error";
        return self::label($options, $captureOutput);
    }

    /**
     * Creates a ColoredLabel with scenario set to "success".
     * @param $text the text which will be colored.
     * @param array $options options for the ColoredLabel widget.
     * @param bool $captureOutput whether output should be captured.
     * @return the markup for the colored label if $captureOutput id true, otherwise null.
     */
    public static function successLabel($text, $options = array(), $captureOutput=false) {
        $options['labelText'] = $text;
        $options['scenario'] = "success";
        return self::label($options, $captureOutput);
    }

    /**
     * Creates a ColoredLabel with scenario set to "alert".
     * @param $text the text which will be colored.
     * @param array $options options for the ColoredLabel widget.
     * @param bool $captureOutput whether output should be captured.
     * @return the markup for the colored label if $captureOutput id true, otherwise null.
     */
    public static function alertLabel($text, $options = array(), $captureOutput=false) {
        $options['labelText'] = $text;
        $options['scenario'] = "alert";
        return self::label($options, $captureOutput);
    }

    /**
     * Creates a ColoredLabel with the options passed to this method.
     * @param $text the text which will be colored.
     * @param array $options options for the ColoredLabel widget.
     * @param bool $captureOutput whether output should be captured.
     * @return the markup for the colored label if $captureOutput id true, otherwise null.
     */
    public static function label($options, $captureOutput=false) {
        $con = Yii::app()->controller;
        return $con->widget("ext.yiigems.widgets.labels.ColoredLabel", $options, $captureOutput);
    }
}

?>
