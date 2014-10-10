<?php

/**
 * HighlightUtil is an utility class to make it convenient to use Highlighter widget. Highlighter
 * 
 * HighlightUtil provides convenient methods for syntax highlighting PHP and HTML
 * code. However, any code can be highlighted by passing the appropriate language attribute.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class HighlightUtil {
    /**
     * Starts a block of PHP code. 
     */
    public static function startPHP($options=array()){
        $options['language'] = "PHP";
        Yii::app()->controller->beginWidget("ext.yiigems.widgets.highlighter.Highlighter", $options);
    }
    
    /**
     * Starts a block of HTML code. 
     * In order that HTML code is displayed correctly, the content inside the
     * Highlighter widget must be encoded correctly.
     */
    public static function startHtml($options=array()){
        $options['language'] = "xml";
        Yii::app()->controller->beginWidget("ext.yiigems.widgets.highlighter.Highlighter", $options);
    }

    /**
     * Starts a highlighter block of code which should be terminated by a call to HighlightUtil::end method.
     * @param $language specifies a language.
     */
    public static function start($options=array()){
        Yii::app()->controller->beginWidget("ext.yiigems.widgets.highlighter.Highlighter", $options);
    }
    
    /**
     * Demotes the ending of a block of code to be syntax highlighted. 
     */
    public static function end(){
        Yii::app()->controller->endWidget();
    }
}

?>
