<?php
/**
 * An Utility class to create tooltips.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class MessageUtil {
    public static function formMessage($content){
        return Yii::app()->controller->widget("ext.yiigems.widgets.message.Message", array(
            'content'=>$content,
            'scenario'=>"formNote",
        ));
    }

}
