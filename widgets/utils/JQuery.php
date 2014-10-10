<?php
/**
 * Description of JQuery
 *
 * @package ext.yiigems.widgets.utils
 * @author Indra K Dutta
 */

class JQuery {
    public static function registerJQuery(){
        Yii::app()->clientScript->registerCoreScript('jquery');
    }
}
?>
