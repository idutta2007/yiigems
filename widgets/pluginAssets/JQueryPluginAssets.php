<?php

/**
 * Description of JQueryPluginAssets
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.pluginAssets
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.pluginAssets.JQueryPluginInfo");

class JQueryPluginAssets extends AppWidget {
    public $plugins = array();
    
    public function setupAssetsInfo(){
        foreach( $this->plugins as $plugin ){
            $pluginInfo = JQueryPluginInfo::getPluginInfo($plugin);
            if ($plugin == "jquery"){
                JQuery::registerJQuery();
            }
            else if ($plugin == "jquery-ui"){
                JQueryUI::registerYiiJQueryUICss();
                JQueryUI::registerYiiJQueryUIScript();
            }
            else if ( $pluginInfo ){
                $assetDir = dirname(__FILE__) . $pluginInfo['assetDir'];
                $files = array_key_exists("files", $pluginInfo) ? $pluginInfo['files'] : array();
                $this->addAssetInfo($files, $assetDir);
            }
        }
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
    }
}

?>
