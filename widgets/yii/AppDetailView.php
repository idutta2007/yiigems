<?php

/**
 * AppDetailView class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.yii
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("zii.widgets.CDetailView");
Yii::import("ext.yiigems.widgets.common.behave.WidgetBehavior");

class AppDetailView extends CDetailView {
    public $styleName = "lightGray";
    public $labelWidth = "20ex";
    
    public function init(){
        $this->attachBehavior( "widget", new WidgetBehavior());
        $this->setupAssetInfo();
        $this->registerAssets();
        
        if ($this->styleName){
            $this->cssFile = $this->getAssetPublishPath("$this->styleName.css") . "/$this->styleName.css";
        }
        $this->itemTemplate = "<tr class='{class}'><th style='width:$this->labelWidth'>{label}</th><td>{value}</td></tr>" ;
        parent::init();
    }
    
    public function setupAssetInfo(){
        if ( $this->styleName ){
            $this->addAssetInfo( "$this->styleName.css", dirname(__FILE__) . "/assets/detailview" );
        }
    }
}

?>
