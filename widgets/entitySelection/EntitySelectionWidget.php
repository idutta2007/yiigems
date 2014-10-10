<?php
/**
 * Description of EntitySelectionWidget
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.entitySelection
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class EntitySelectionWidget extends AppWidget {
    public $dialogId;
    public $gridId;
    public $inputFieldOptions = array();
    
    public $model;
    public $column;
    public $displayValue;
    
    public function init() {
        parent::init();
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();
        
        // Hidden field containg id
        echo CHtml::activeHiddenField($this->model, $this->column);

        // Input field displaying name
        $inputFieldId = UniqId::get("ent-");
        $inputFieldOptions = ComponentUtil::mergeHtmlOptions(array(
            'id' => $inputFieldId,
            'readonly' => true,
            'value' => $this->displayValue,
            'size'=> 40,
        ), $this->inputFieldOptions);
        echo CHtml::tag("input", $inputFieldOptions);

        echo Yii::app()->controller->widget("ext.yiigems.widgets.buttons.GradientButton", array(
            'label' => "...",
            'buttonType' => 'action',
            'script' => "$('#$this->dialogId').dialog('open');",
            'options' => array('style' => 'margin-left:0.5em;padding: 0.2em 0.5em')
        ), true);
    }
}

?>
