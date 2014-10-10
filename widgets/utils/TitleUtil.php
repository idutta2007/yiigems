<?php
/**
 * An Utility class to create Title and TitleHeader widget.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class TitleUtil {
    /**
     * Creates a title header with the given scenario.
     * @param $title specifies the title text to be displayed on the header.
     * @param string $scenario specifies a scenario in the active skin.
     */
    public static function titleHeader( $title, $scenario=null ) {
        $con = Yii::app()->controller;
        
        if (is_array($scenario)) {
            $scenario['titleText'] = $title;
            return $con->widget("ext.yiigems.widgets.title.TitleHeader", $scenario);
        }
        
        return $con->widget("ext.yiigems.widgets.title.TitleHeader", array(
            'titleText'=> $title,
            'scenario'=>$scenario
        ));
    }

    /**
     * Creates a title bar with the given options.
     * @param $title specifies the title text to be displayed on the header.
     * @param array options specifies the options for the Title widget.
     */
    public static function titleBar( $title, $options=array() ) {
        $con = Yii::app()->controller;
        if (is_array($options)) {
            $options['titleText'] = $title;
            return $con->widget("ext.yiigems.widgets.title.TitleBar", $options);
        }
        return $con->widget("ext.yiigems.widgets.title.TitleBar", array(
            'titleText'=> $title,
            'scenario'=>$options
        ));
    }

    /**
     * Method to emphasize a text. Can be used to display part of the header text emphasized.
     * @param $text the text to be emphasized.
     * @param string $style the CSS style for the emphasized text.
     * @return string  returns the markup that emphasizes the text.
     */
    public static function emphasize( $text, $style="color:white;font-size:12px;font-weight:bold;font-style:italic" ){
        return "<em style='$style'>$text</em>";
    }
}
?>
