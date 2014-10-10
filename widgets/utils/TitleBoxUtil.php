<?php

/**
 * An utility class to create TitleBox widgets easily.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class TitleBoxUtil {
    /**
     * Marks the start of the title box content.
     * @param $title Specifies the title text displayed in the header.
     * @param array $options  additional options for the title box.
     */
    public static function startBox($title, $options=array()){
        $localOptions = array(
            'titleText'=>$title,
        );
        $options = array_merge($localOptions, $options );
        Yii::app()->controller->beginWidget("ext.yiigems.widgets.titleBox.TitleBox", $options );
    }

    /**
     *  Marks the end of the current titleBox.
     */
    public static function endBox(){
        Yii::app()->controller->endWidget();
    }
}

?>
