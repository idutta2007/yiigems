<?php

/**
 * Description of CellEditor
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.yii
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import( "ext.yiigems.widgets.popup.Popup");
Yii::import( "ext.yiigems.widgets.common.utils.RoundStyleUtil");

class EditableField extends Popup {
    public $gridId;
    
    /** Model associated with the editor */
    public $model;
    
    /** The attribute being edited */
    public $attribute;
    
    /** The text displayed on link on the editable cell. */
    public $linkText;
    
    /** The HTML options for the link text */
    public $linkTextOptions = array();
    
    /** The text to display if the content is empty */
    public $emptyText = "Click To Edit";
    
    /** Max length of string displayed */
    //public $maxLinkTextLength = 15;
    
    /** 
     * Type of control to be displayed to in the editor. The valid values are
     * "textField", "textArea", "dropdownList", "chosen", "checkBox", "radioButton",
     * "checkBoxList", "radioButtonList", "datePicker", "timePicker", "monthPicker",
     * "yearPicker", "monthYearPicker"
     */
    public $controlType;
    
    /** 
     * The options passed to the control which could be htmlOptions ot widget options 
     * depending on the type of control.
     */
    public $controlOptions = array();
    
    /** The options for the Ok button */
    public $okButton = array();
    protected $okBtnClass = "okBtn";
    
    /** The options for the cancel button */
    public $cancelButton= array();
    protected $cancelBtnClass = "cancelBtn";
    
    public $template = "{input}{okButton}{cancelButton}";
    
    /** The url to which the editor will post data to save. Model id and attribute name will be appended */
    public $updateUrl;
    
    protected function setupAssetsInfo() {
        parent::setupAssetsInfo();
        $path = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . "/assets/editors");
        Yii::app()->getClientScript()->registerCssFile($path . "/editableField.css");
        Yii::app()->getClientScript()->registerScriptFile($path . "/editableField.js");
    }
    
    protected function setMemberDefaults() {
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : $this->getPopupId();
        if (!$this->headerText ){
            $displayName = ucwords(trim(strtolower(str_replace(array('-','_','.'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $this->attribute)))));
            $this->headerText = "Enter $displayName";
        }
    }
    
    public function init() {
        parent::init();
        $this->registerAssets();
        
        // Get the input markup
        $input = null;
        switch( $this->controlType ){
           case "textField":
               $input = $this->createTextField();
           break;
       
           case "integerField":
               $input = $this->createIntegerField();
           break;
       
           case "decimalField":
               $input = $this->createDecimalField();
           break;
       
           case "textArea":
               $input = $this->createTextArea();
           break;
        }
        
        // Get ok and cacel button markup
        $okBtn = $this->createOkButton();
        $cancelBtn = $this->createCancelButton();
        
        // Create the content using the template
        $result = str_replace( "{input}", $input, $this->template);
        $result = str_replace( "{okButton}", $okBtn, $result);
        $result = str_replace( "{cancelButton}", $cancelBtn, $result);
        echo $result;
    }
    
    public function run(){
        parent::run();
        $this->registerClientScript();
    }
    
    public function createTextField() {
        $options = array();
        $options['type'] = 'text';
        $options['class'] = $this->roundStyle;
        $options = ComponentUtil::mergeHtmlOptions($options, $this->controlOptions);
        return CHtml::tag("input", $options);
    }
    
    public function createIntegerField() {
        return $this->widget("ext.yiigems.widgets.inputs.NumberField", array(
            'inputType' => 'integer',
            'addClass' => $this->roundStyle,
            'htmlOptions' => array('size'=> 12)
        ), true);
    }
    
    public function createDecimalField() {
        return $this->widget("ext.yiigems.widgets.inputs.NumberField", array(
            'inputType' => 'decimal',
            'addClass' => $this->roundStyle,
            'htmlOptions' => array('size'=> 12)
        ), true);
    }
    
    public function createTextArea(){
        $options = array();
        $options['type'] = 'textarea';
        $options['rows'] = 5;
        $options['cols'] = 30;
        $options['class'] = $this->roundStyle;
        $options = ComponentUtil::mergeHtmlOptions($options, $this->controlOptions);
        
        $this->template = "{input}<br/>{okButton}{cancelButton}";
        
        $markup = CHtml::openTag("textarea", $options);
        $markup .= CHtml::closeTag("textarea");
        return $markup;
    }
    
    public function createOkButton(){
        $options = array();
        $options['addClass'] = $this->okBtnClass;
        $options['label'] = "";
        $options['url'] = "javascript:void(0)";
        $options['fontSize'] = $this->fontSize;
        $options['iconClass'] = "icon-ok";
        $this->okButton = array_merge($options, $this->okButton);
        return $this->widget("ext.yiigems.widgets.buttons.GradientButton", $this->okButton, true);
    }
    
    public function createCancelButton(){
        $options = array();
        $options['addClass'] = $this->cancelBtnClass;
        $options['label'] = "";
        $options['url'] = "javascript:void(0)";
        $options['fontSize'] = $this->fontSize;
        $options['iconClass'] = "icon-remove";
        $this->cancelButton = array_merge($options, $this->cancelButton);
        return $this->widget("ext.yiigems.widgets.buttons.GradientButton", $this->cancelButton, true );
    }
    
    public function renderLink(){
        // Trim the text to be displayed. This avoid problems when the string contains only while spaces.
        if ($this->linkText) $this->linkText = trim($this->linkText);
        
        echo CHtml::openTag('a', $this->computeLinkOptions());
        echo $this->linkText ? $this->linkText : $this->emptyText;
        echo CHtml::closeTag('a');
    }
    
    public function computeLinkOptions(){
        $linkOptions = array(
            'href' => 'javascript:void(0)',
            'class' => 'editorLink',
            'style' =>'text-overflow:ellipsis',
            'data-column-id' => $this->getColumnId(),
            'data-model-id' => (string)$this->model->id,
            'data-attribute-name' => (string)$this->attribute,
            'data-link-text' => $this->linkText,
        );
        return ComponentUtil::mergeHtmlOptions($linkOptions, $this->linkTextOptions );
    }
    
    public function getColumnId(){
        return "{$this->gridId}-{$this->attribute}";
    }
    
    public function getPopupId(){
        return "{$this->gridId}-{$this->attribute}-popup";
    }
    
    public function getOkButtonSelector(){
        return "#" . $this->getPopupId() . " ." . $this->okBtnClass;
    }
    
    public function getCancelButtonSelector(){
        return "#" . $this->getPopupId() . " ." . $this->cancelBtnClass;
    }
    
    /**
     * Script is regsitered when the first cell in the column is rendered.
     */
    public function registerClientScript(){
        $popupId = $this->getPopupId();
        $columnId = $this->getColumnId();
        $okButtonSelector = $this->getOkButtonSelector();
        $cancelButtonSelector = $this->getCancelButtonSelector();
        $updateUrl = is_string($this->updateUrl )? $this->updateUrl : CHtml::normalizeUrl($this->updateUrl);
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            $('#$popupId').editableField({
                gridId: '$this->gridId',
                columnId: '$columnId',
                popupId: '$popupId',
                okButtonSelector: '$okButtonSelector',
                cancelButtonSelector: '$cancelButtonSelector',
                updateUrl: '$updateUrl',
                emptyText: '$this->emptyText'
            });
        ");
    }
}

?>
