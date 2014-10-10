<?php

/**
 * Description of OpenFlashChart2
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.openFlashChart
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class OpenFlashChart2 extends AppWidget {
    public $width = 600;
    public $height = 400;
    public $dataUrl = null;
    public $flashVersion = "9.0.0";
    public $data;
    public $dataFile;
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
                "swfobject.js", 
                dirname(__FILE__) . "/assets"
        );
    }
    
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("swf_");
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag("div", array(
            'id'=>$this->id
        ));
        echo CHtml::closeTag("div");
    }
    
    public function run(){
        $publishPath = $this->getAssetPublishPath("swfobject.js");
        $getDataFunction = "get_data_$this->id";
        if ($this->dataFile) {
            Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
                swfobject.embedSWF(
                   '$publishPath/open-flash-chart.swf', 
                   '$this->id', '$this->width', '$this->height', 
                   '$this->flashVersion', 'expressInstall.swf',
                   {'data-file': '$this->dataFile'}
                );
            ");
        }
        else if ($this->data) {
            $data = json_encode($this->data);
            Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
                window['$getDataFunction'] = function(){
                    return '$data';
                }
                swfobject.embedSWF(
                   '$publishPath/open-flash-chart.swf', 
                   '$this->id', '$this->width', '$this->height', 
                   '$this->flashVersion', 'expressInstall.swf',
                   { 'get-data':'$getDataFunction', 'id':'$this->id'}
                );
            ");
        }
    }
}

?>
