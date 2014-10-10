<?php

/**
 * Description of MaskedInputField
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.inputs
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class MaskedInputField extends AppWidget {
    public $htmlOptions = array();
    public $mask;
    public $placeholder = "_";
    
    protected function setupAssetsInfo() {
        Yii::app()->controller->widget("ext.yiigems.widgets.pluginAssets.JQueryPluginAssets", array(
            'plugins' => array( "maskedInput")
        ));
    }
    
    protected function setMemberDefaults() {
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("mi-");
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
            'class' => 'maskedInput',
        ));
        $options = ComponentUtil::mergeHtmlOptions($options, $this->htmlOptions);
        $this->id = $options['id'];
        echo CHtml::tag("input", $options);
    }
    
    public function run() {
        if ( !$this->mask ) return;
        
        Yii::app()->clientScript->registerScript( UniqId::get('mi-'), "
            \$('#$this->id').mask('$this->mask', {placeholder: '$this->placeholder'});
        ");
    }
}

?>
