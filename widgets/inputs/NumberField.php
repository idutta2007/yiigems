<?php

/**
 * Description of NumberField
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.inputs
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class NumberField extends AppWidget {
    public $htmlOptions = array();
    public $inputType = "decimal";
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        JQueryUI::registerYiiJQueryUIResources();
        $this->addAssetInfo( "inputFields.js", dirname(__FILE__) . "/assets" );
    }

    
    protected function setMemberDefaults() {
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("nf-");
        if (!array_key_exists("type", $this->htmlOptions)){
            $this->htmlOptions['type'] = "text";
        }
    }
    
    public function init() {
        parent::init();
        $this->registerAssets();
        
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'addClass' => $this->addClass,
            'class' => 'numberField',
        ));
        $options = ComponentUtil::mergeHtmlOptions($options, $this->htmlOptions);
        $this->id = $options['id'];
        echo CHtml::tag("input", $options);
    }
    
    public function run() {
        Yii::app()->clientScript->registerScript( UniqId::get('nf-'), "
            \$('#$this->id').numberField({ inputType: '$this->inputType' });
        ");
    }
}

?>
