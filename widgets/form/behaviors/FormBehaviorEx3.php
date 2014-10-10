<?php

/**
 * Behavior for InputGroups.
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form.behaviors
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.logictowers.com/yiigems/license/
 */

Yii::import("ext.yiigems.widgets.common.utils.RoundStyleUtil");
Yii::import("ext.yiigems.widgets.inputs.InputGroupUtil");

class FormBehaviorEx3 extends CBehavior {
    
    /** The list of all input groups supported by ActiveModelForm */
    public $allGroups = array(
            'textFieldGroup', 'textAreaGroup', 'passwordFieldGroup', 'integerFieldGroup', 
            'decimalFieldGroup', 'telephoneFieldGroup', 'emailFieldGroup', 
            'maskedInputFieldGroup', 'textAreaFieldGroup',
            'checkBoxGroup', 'radioButtonGroup', 'dropdownListGroup',
            'listBoxGroup', 'chosenFieldGroup', 
            'checkBoxListGroup', 'radioButtonListGroup', 'fileFieldGroup',
            'datePickerGroup', 'timePickerGroup',
            'monthPickerGroup', 'yearPickerGroup', 'monthYearPickerGroup',
            'autoCompleteGroup'
    );
    
    /**
     * Generates the markup for an input group for a text field. The options 
     * associated with the column determines what is created in the inut group.
     * The options for the element has the following form:
     * - The list of properties for InputGroup
     * - A property named textField which is an array containing options for 
     * the textField
     * 
     * @param type $model A CModel object such as ActiveRecord.
     * @param type $column name of database column.
     * @return String the markup gor the input group as a string. 
     */
    public function textFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'textFieldGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'textField');
        return $this->createInputGroup($model, $column, $options, 'textField');
    }
    
    private function updateTextPlaceholder($model, $column, &$options, $inputName){
        // If the leftContent is detected to be an icon set placeholder for text
        if ( $this->isLeftContentIcon($options)){
            if (!array_key_exists($inputName, $options) ) $options[$inputName] = array();
            if (!array_key_exists("htmlOptions", $options[$inputName]) ) $options[$inputName]['htmlOptions'] = array();
        
            if (!array_key_exists("placeholder", $options[$inputName]['htmlOptions']) ){
                $options[$inputName]['htmlOptions']['placeholder'] = $model->getAttributeLabel($column);
            }
        }
    }
    
    public function passwordFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'passwordFieldGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'passwordField');
        return $this->createInputGroup($model, $column, $options, 'passwordField');
    }
    
    public function textAreaGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'textAreaGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'textArea');
        return $this->createInputGroup($model, $column, $options, 'textArea');
    }
    
    public function checkBoxGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'checkBoxGroup' );
        return $this->createListInputGroup($model, $column, $options, 'checkBox');
    }
    
    public function radioButtonGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'radioButtonGroup' );
        return $this->createListInputGroup($model, $column, $options, 'radioButton');
    }
    
    public function fileFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'fileFieldGroup' );
        return $this->createInputGroup($model, $column, $options, 'fileField');
    }
    
    public function dropdownListGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'dropdownListGroup' );
        return $this->createInputGroup($model, $column, $options, 'dropdownList');
    }
    
    public function listBoxGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'listBoxGroup' );
        return $this->createInputGroup($model, $column, $options, 'listBox');
    }
    
    public function checkBoxListGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'checkBoxListGroup' );
        return $this->createListInputGroup($model, $column, $options, 'checkBoxList');
    }
    
    public function radioButtonListGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'radioButtonListGroup' );
        return $this->createListInputGroup($model, $column, $options, 'radioButtonList');
    }
    
    public function integerFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'integerFieldGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'integerField');
        return $this->createInputGroup($model, $column, $options, 'integerField');
    }
    
    public function decimalFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'decimalFieldGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'decimalField');
        return $this->createInputGroup($model, $column, $options, 'decimalField');
    }
    
    public function telephoneFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'telephoneFieldGroup' );
        return $this->createInputGroup($model, $column, $options, 'telephoneField');
    }
    
    public function emailFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'emailFieldGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'emailField');
        return $this->createInputGroup($model, $column, $options, 'emailField');
    }
    
    public function maskedInputFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'maskedInputFieldGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'maskedInputField');
        return $this->createInputGroup($model, $column, $options, 'maskedInputField');
    }
    
    public function chosenFieldGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'chosenFieldGroup' );
        if ( !array_key_exists("chosenField", $options) ){
            $options['chosenField'] = array();
        }
        if (!array_key_exists("pluginOptions", $options['chosenField'])){
            $options["chosenField"]["pluginOptions"] = array();
        }
        $options["chosenField"]["pluginOptions"]["width"] = "100%";
        return $this->createInputGroup($model, $column, $options, 'chosenField');
    }
    
    public function datePickerGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'datePickerGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'datePicker');
        return $this->createInputGroup($model, $column, $options, 'datePicker');
    }
    
    public function timePickerGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'timePickerGroup' );
        if ( !array_key_exists("timePicker", $options) ){
            $options['timePicker'] = array();
        }
        if (!array_key_exists("htmlOptions", $options['timePicker'])){
            $options["timePicker"]["htmlOptions"] = array();
        }
        $options["timePicker"]["htmlOptions"] = ComponentUtil::mergeHtmlOptions(
                $options["timePicker"]["htmlOptions"], 
                array( 'style' => 'width:100%')
        );
        return $this->createInputGroup($model, $column, $options, 'timePicker');
    }
    
    public function monthPickerGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'monthPickerGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'monthPicker');
        return $this->createInputGroup($model, $column, $options, 'monthPicker');
    }
    
    public function yearPickerGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'yearPickerGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'yearPicker');
        return $this->createInputGroup($model, $column, $options, 'yearPicker');
    }
    
    public function monthYearPickerGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'monthYearPickerGroup' );
        $this->updateTextPlaceholder($model, $column, $options, 'monthYearPicker');
        return $this->createInputGroup($model, $column, $options, 'monthYearPicker');
    }
    
    public function autoCompleteGroup($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, 'autoCompleteGroup' );
        return $this->createInputGroup($model, $column, $options, 'autoComplete');
    }
    
    /**
     * Generates the markup for the input group element.
     * @param type $model a CModel object
     * @param type $column name of a field in CModel
     * @param array $options the effective options for the input group
     * @param type $inputName the name of an input element such as textField, chosenField.
     * @return type returns the markup for the inut group.
     */
    public function createInputGroup($model, $column, $options, $inputName){
        // Update the leftContent and rightContent 
        $this->updateOptions($model, $column, $options, "leftContent");
        $this->updateOptions($model, $column, $options, "rightContent");
        
        
        // Create the input
        $inputOptions = array_key_exists($inputName, $options) ? $options[$inputName] : array();
        unset($options[$inputName]);
        
        $inputHtmlOptions = array_key_exists('htmlOptions', $inputOptions) ? $inputOptions['htmlOptions'] : array();
        $inputOptions['htmlOptions'] = InputGroupUtil::computeInputHtmlOptions(array(
            'hasLeftContent' => array_key_exists("leftContent", $options),
            'hasRightContent' => array_key_exists("rightContent", $options),
            'groupRoundStyle' => array_key_exists("roundStyle", $options) ? $options['roundStyle'] : null,
            'htmlOptions' => $inputHtmlOptions
        ));
        
        $options['inputContent'] = $this->owner->$inputName($model, $column, $inputOptions );
        
        return Yii::app()->controller->widget("ext.yiigems.widgets.inputs.InputGroup", $options, true);
    }
    
    /**
     *  This method should be used for checkBoxListGroup and radioButtonListGroup
     * @param array $options for the input group
     * @param type $inputName is one of checkBoxList or radioButtonList
     * @return type
     */
    private function createListInputGroup($model, $column, $options, $inputName){
        // Update the leftContent and rightContent 
        $this->updateOptions($model, $column, $options, "leftContent");
        $this->updateOptions($model, $column, $options, "rightContent");
        
        
        // Wrap the markup in a div
        $htmlOptions = InputGroupUtil::computeInputHtmlOptions(array(
            'hasLeftContent' => array_key_exists("leftContent", $options),
            'hasRightContent' => array_key_exists("rightContent", $options),
            'groupRoundStyle' => array_key_exists("roundStyle", $options) ? $options['roundStyle'] : null,
            'htmlOptions' => array( 'style'=>'padding:1ex 2ex')
        ));
        $markup = CHtml::openTag( "div", $htmlOptions );
        
        // Create the input markup
        $inputOptions = array_key_exists($inputName, $options) ? $options[$inputName] : array();
        unset($options[$inputName]);
        $markup .= $this->owner->$inputName($model, $column, $inputOptions );
        $markup .= CHtml::closeTag("div");
        
        $options['inputContent'] = $markup;
        
        return Yii::app()->controller->widget("ext.yiigems.widgets.inputs.InputGroup", $options, true);
    }
    
    private function isLeftContentIcon($options){
        $leftContent = array_key_exists("leftContent", $options) ? $options['leftContent'] : null;
        if (is_array($leftContent)){
            $type = array_key_exists( "type", $leftContent ) ? $leftContent['type'] : null;
            if ( $type === "icon" ) return true;
        }
        return false;
    }
    
    /**
     * Returns true if leftContent or rightContent is a label, otherwise, false.
     * @param type $options the list of options for the input group.
     * @param type $contentType is either "leftContent" or "rightContent"
     * @return boolean whether the content is a label.
     */
    private function isLabelContent($options, $contentType){
        $content = array_key_exists($contentType, $options) ? $options[$contentType] : null;
        if (is_array($content)){
            $type = array_key_exists( "type", $content ) ? $content['type'] : null;
            if ( $type === "label" || $type =='coloredLabel') return true;
        }
        return false;
    }
    
    private function isTextContent($options, $contentType){
        $content = array_key_exists($contentType, $options) ? $options[$contentType] : null;
        if (is_array($content)){
            $type = array_key_exists( "type", $content ) ? $content['type'] : null;
            if ( $type === "text") return true;
        }
        return false;
    }
    
    /**
     * Update leftContent or rightContent with default text or labels if missing.
     * @param type $options $options the list of options for the input group.
     * @param type $contentType $contentType is either "leftContent" or "rightContent"
     * @param type $inputName name of the input element like "textField", "chosenField" etc.
     */
    private function updateOptions($model, $column, &$options, $contentType){
        // If content is a label, update label text if not given
        if ( $this->isLabelContent($options, $contentType )){
           $content = $options[$contentType];
           $labelText = array_key_exists('labelText', $content) ? $content['labelText'] : false;
           if (!$labelText){
               $options[$contentType]['labelText'] = $model->getAttributeLabel($column);
               if ( $model->isAttributeRequired($column)){
                   $options[$contentType]['labelText'] .= " <span class='required'>*</span>";
               }
           } 
        }
        
        // If content is a text, update text attribute if not given
        if ( $this->isTextContent($options, $contentType )){
           $content = $options[$contentType];
           $text = array_key_exists('text', $content) ? $content['text'] : false;
           if (!$text){
               $options[$contentType]['text'] = $model->getAttributeLabel($column);
               if ( $model->isAttributeRequired($column)){
                   $options[$contentType]['text'] .= " <span class='required'>*</span>";
               }
           } 
        }
    }
    
    public function setContentForGroups($contentType, $content, $groups="all"){
        $groups = $groups == "all" ? $this->allGroups : preg_split("/[,\s]/", $groups, -1, PREG_SPLIT_NO_EMPTY);
        foreach( $groups as $group ){
            $value = array_key_exists($group, $this->owner->formConfig) ? $this->owner->formConfig[$group] : array();
            $value = array_merge($value, array(
                $contentType => $content
            ));
            $this->owner->formConfig[$group] =  $value;
        }
    }
    
    public function setContentForField($model, $column, $contentType, $content, $groups="all"){
        $groups = $groups == "all" ? $this->allGroups : preg_split("/[,\s]/", $groups, -1, PREG_SPLIT_NO_EMPTY);
        
        foreach( $groups as $group ){
            $index = $this->getIndexForItemConfig($model, $column);
            if ( $index === false){
                $this->owner->itemsConfig[] = array($model, $column, array(
                    $group => array($contentType => $content)
                ));
            }
            else {
                if (!array_key_exists($group, $this->owner->itemsConfig[$index][2])){
                    $this->owner->itemsConfig[$index][2][$group] =  array();
                }
                $this->owner->itemsConfig[$index][2][$group] = array_merge(
                     $this->owner->itemsConfig[$index][2][$group],
                     array($contentType => $content)
                );
            }
        }
    }
    
    public function setLeftIconForGroups($iconClass="icon-edit", $groups="all"){
        $content = array('type' => 'icon', 'iconClass' => $iconClass );
        $this->setContentForGroups("leftContent", $content, $groups);
    }
    
    public function setLeftIconForField($model, $column, $iconClass="icon-edit", $groups="all"){
        $content = array('type' => 'icon', 'iconClass' => $iconClass );
        $this->setContentForField($model, $column, "leftContent", $content, $groups);
    }
    
    public function setRightIconForGroups($iconClass="icon-edit", $groups="all"){
        $content = array('type' => 'icon', 'iconClass' => $iconClass );
        $this->setContentForGroups("rightContent", $content, $groups);
    }
    
    public function setRightIconForField($model, $column, $iconClass="icon-edit", $groups="all"){
        $content = array('type' => 'icon', 'iconClass' => $iconClass );
        $this->setContentForField($model, $column, "rightContent", $content, $groups);
    }
    
    
    public function useTextLabelsForGroups( $width="20ex", $groups="all"){
        $content = array('type' => 'text', 'style' => "width:$width;border-color:#aaa");
        $this->setContentForGroups("leftContent", $content, $groups);
    }
    
    public function useColoredLabelsForGroups( $options=array(), $groups="all" ){
        // If empty array is passed use a label of width 20ex
        if(is_array($options) && count($options) == 0) {
            $options = array( 'type'=>'coloredLabel', 'options' => array('style'=>'width:20ex'));
        }
        
        // If options is string, it is the width of the label
        if(is_string($options)) {
            $options = array('type'=>'coloredLabel', 'options' => array('style'=>"width:$options"));
        }
        $this->setContentForGroups("leftContent", $options, $groups);
    }
    
    public function useColoredLabelsForField( $model, $column, $options=array(), $groups="all" ){
        // If empty array is passed use a label of width 20ex
        if(is_array($options) && count($options) == 0) {
            $options = array( 'type'=>'coloredLabel', 'options' => array('style'=>'width:20ex'));
        }
        
        // If options is string, it is the width of the label
        if(is_string($options)) {
            $options = array('type'=>'coloredLabel', 'options' => array('style'=>"width:$options"));
        }
        $this->setContentForField($model, $column, "leftContent", $options, $groups);
    }
    
    public function setNoLeftContentForGroups($groups="all"){
        $this->setContentForGroups("leftContent", null, $groups);
    }
    
    public function setNoLeftContentForField($model, $column, $groups="all"){
        $columns = preg_split("/[,\s]/", $column, -1, PREG_SPLIT_NO_EMPTY);
        foreach( $columns as $col ){
            $this->setContentForField($model, $col, 'leftContent', null, $groups);
        }
    }
    
    public function setNoRightContentForGroups($groups="all"){
        $this->setContentForGroups("rightContent", null, $groups);
    }
    
    public function setNoRightContentForField($model, $column, $groups="all"){
        $columns = preg_split("/[,\s]/", $column, -1, PREG_SPLIT_NO_EMPTY);
        foreach( $columns as $col ){
            $this->setContentForField($model, $col, 'rightContent', null, $groups);
        }
    }
    
    public function getIndexForItemConfig( $model, $column ){
        foreach($this->owner->itemsConfig as $index=>$config ){
            if ( $config[0] === $model && $config[1] === $column){
                return $index;
            }
        }
        return false;
    }
}

?>
