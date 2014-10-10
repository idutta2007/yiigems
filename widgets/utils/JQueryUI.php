<?php
/**
 * Description of JQueryUI
 *
 * @package ext.yiigems.widgets.utils
 * @author Indra K Dutta
 */
class JQueryUI {
    public static $themes = array(
        "black-tie"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/black-tie/jquery-ui.css",
        "blitzer"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/blitzer/jquery-ui.css",
        "cupertino"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/cupertino/jquery-ui.css",
        "dark-hive"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/dark-hive/jquery-ui.css",
        "dot-luv"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/dot-luv/jquery-ui.css",
        "eggplant"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/eggplant/jquery-ui.css",
        "excite-bike"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/excite-bike/jquery-ui.css",
        "flick"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/flick/jquery-ui.css",
        "hot-sneaks"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/hot-sneaks/jquery-ui.css",
        "humanity"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/humanity/jquery-ui.css",
        "le-frog"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/le-frog/jquery-ui.css",
        "mint-choc"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/mint-choc/jquery-ui.css",
        "overcast"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/overcast/jquery-ui.css",
        "pepper-grinder"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/pepper-grinder/jquery-ui.css",
        "redmond"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/redmond/jquery-ui.css",
        "smoothness"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css",
        "south-street"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/south-street/jquery-ui.css",
        "start"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/start/jquery-ui.css",
        "sunny"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/sunny/jquery-ui.css",
        "swanky-purse"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/swanky-purse/jquery-ui.css",
        "trontastic"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/trontastic/jquery-ui.css",
        "ui-darkness"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-darkness/jquery-ui.css",
        "ui-lightness"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css",
        "vader"=>"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/vader/jquery-ui.css",
    );
    
    public static function registerYiiJQueryUIResources(){
        Yii::app()->clientScript->registerCssFile(
                Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'
        );
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
    }

    public static function registerYiiJQueryUIScript(){
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
    }

    public static function registerYiiJQueryUICss() {
        Yii::app()->clientScript->registerCssFile(
                Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'
        );
    }


    public static function registerJQueryUICssFromWeb( $theme = "redmond"){
        CssHelper::registerCssFromWeb( JQueryUI::$themes[$theme], "screen" );
    }

    public static function registerJQueryUIScriptFromWeb(){
        JsHelper::registerJsFileFromWeb( "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js" );
    }
}
?>