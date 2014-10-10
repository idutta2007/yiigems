<?php

/**
 * Description of ChosenField
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.chosen
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.chosen.ListData");
Yii::import("ext.yiigems.widgets.chosen.ChosenFieldDefaults");

class ChosenField extends AppWidget {
    public $listData = array();
    public $selectedItem;
    public $selectedItems = array();
    public $htmlOptions = array();
    public $pluginOptions = array();
    
    public $skinClass = "ChosenFieldDefaults";

    public function setupAssetsInfo() {
        $this->widget("ext.yiigems.widgets.pluginAssets.JQueryPluginAssets", array(
            'plugins' => array('jquery', "jquery-ui", "chosen")
        ));
    }

    public function getMergedFields() {
        return array( 'htmlOptions', "pluginOptions" );
    }

    public function setMemberDefaults() {
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id: UniqId::get('czn-');
        if (is_array($this->listData)){
            $listData = new ListData;
            $listData->options = $this->listData;
            $listData->normalizeOptions();
            $this->listData = $listData;
        }
        foreach($this->selectedItems as $item ){
            $this->listData->setSelected($item, true);
        }
        if ($this->selectedItem){
            $this->listData->setSelected($this->selectedItem, true);
        }
    }

    public function init() {
        parent::init();
        $this->registerAssets();
        
        $options = ComponentUtil::computeHtmlOptions(array(
            'id'=> $this->id,
            'class'=> "chosen",
            'addClass'=> $this->addClass,
        ));
        $options = ComponentUtil::mergeHtmlOptions( $options, $this->htmlOptions );
        $this->id = $options['id'];

        echo CHtml::openTag( "select", $options );
        echo $this->listData->getOptionsMarkup();
    }

    public function run() {
       echo CHtml::closeTag( "select" );

       $json = count($this->pluginOptions) ? json_encode( $this->pluginOptions ) : "";
       Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
           \$('#$this->id').chosen($json);
       ");
    }
}

?>
