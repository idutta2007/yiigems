<?php

/**
 * Add additonal form behaviors for ActiveModelForm especially for those input
 * fields related to jquery plugins.
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form.behaviors
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.chosen.ListData");
Yii::import("ext.yiigems.widgets.chosen.ChosenField");

class FormBehaviorEx1 extends CBehavior  {
    /**
     * Creates the markup for popup help for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @return string returns the markup for the popup hint.
     */
    public function popupHelp($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, "popupHelp");
        if ( array_key_exists( "content", $options ) ||
            array_key_exists( "contentSelector", $options ) ||
            array_key_exists( "contentUrl", $options ) ){
            $id = UniqId::get( "img-");
            $options['target'] = "#" . $id;
            $options['items'] = "#" . $id;
            $options['topPos'] = array( "my" => "left-53 bottom-10", "at" => "center top");
            $options['location'] = "top";
            $label = $this->owner->getHelpImageTag($id);
            Yii::app()->controller->widget( "ext.yiigems.widgets.tooltips.Tooltip", $options);
            return $label;
        }
        return "";
    }
  

    public function tooltip($model, $column){
        $options = $this->owner->computeElementOptions($model, $column, "tooltip");
        if ( array_key_exists( "content", $options ) ||
            array_key_exists( "contentSelector", $options ) ||
            array_key_exists( "contentUrl", $options ) ){
            $options['target'] = "#" . CHtml::activeId($model, $column);
            $options['items'] =  $options['target'];
            $options['scenario'] =  "form";
            Yii::app()->controller->widget( "ext.yiigems.widgets.tooltips.Tooltip", $options);
        }
        return "";
    }
    
    public function maskedInputField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->owner->computeElementOptions($model, $attribute, "maskedInputField");
        $mask = array_key_exists( "mask", $options ) ? $options["mask"] : null;
        $placeholder = array_key_exists( "placeholder", $options ) ? $options["placeholder"] : "_";
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $htmlOptions['id'] = array_key_exists( "id", $htmlOptions ) ? $htmlOptions['id'] : CHtml::activeId($model, $attribute);
        $htmlOptions['value'] = $model->$attribute;
        $htmlOptions['type'] = "text";
        
        return Yii::app()->controller->widget("ext.yiigems.widgets.inputs.MaskedInputField", array(
            'htmlOptions' => $htmlOptions,
            'mask' => $mask,
            'placeholder' => $placeholder,
        ), true);
    }
    
    /**
     * Creates the markup of a date picker for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the date picker.
     * @return string returns the markup for a date picker.
     */
    public function datePicker($model, $column, $options=null ) {
        $options = $options? $options : $this->owner->computeElementOptions($model, $column, "datePicker");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();

        $dateValue = $model->$column;
        if ( is_numeric($dateValue) && $dateValue > 0 ){
            $dateValue = date( 'd-M-Y', $model->$column );
        }
        
        $controller = Yii::app()->controller;
        return $controller->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>get_class($model) . "[$column]",
                'value'=>"$dateValue",

                // additional javascript options for the date picker plugin
                'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'dd-M-yy',
                ),
                'htmlOptions'=>$htmlOptions
        ), true);
    }
    
    /**
     * Creates the markup of a time picker for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the time picker.
     * @return string returns the markup for a time picker.
     */
    public function timePicker($model, $column, $options=null) {
        $options = $options? $options : $this->owner->computeElementOptions($model, $column, "timePicker");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();

        $dateValue = $model->$column;
        
        $controller = Yii::app()->controller;
        return $controller->widget("ext.yiigems.widgets.timePicker.TimePicker", array(
            'id'=>get_class($model) . "_" . "$column",
            'name'=>get_class($model) . "[$column]",
            'value'=>"$dateValue",
            'htmlOptions'=>$htmlOptions
        ), true);
    }
    
    public function photoBooth( $model, $column, $options=array()) {
        $options = $this->owner->computeElementOptions($model, $column, "photoBooth");
        return $this->owner->widget('ext.yiigems.widgets.photoBooth.PhotoBooth', $options, true );
    }
    
    public function photoBoothSnapshot( $model, $column) {
        $options = $this->owner->computeElementOptions($model, $column, "photoBoothSnapshot");
        $imageHolderId = array_key_exists('imageHolderId', $options)? $options['imageHolderId'] : "";
        $dataUrl = array_key_exists('dataUrl', $options)? $options['dataUrl'] : "";
        $markup = CHtml::openTag("div", array(
            'id'=>$imageHolderId
        ));
        if ( $dataUrl ){
            $markup .= "<img src='$dataUrl'/>";
        }
        $markup .= CHtml::closeTag("div");
        return $markup;
    }
    
    public function chosenField($model, $attribute, $options = null) {
        $options = $options ? $options : $this->owner->computeElementOptions($model, $attribute, "chosenField");
        
        // List of items can be passed as 'items' or 'listData'
        $items =  array_key_exists( "items", $options ) ? $options["items"] : array();
        $items =  array_key_exists( "listData", $options ) ? $options["listData"] : $items;
        
        // Create the ListData object
        $listData = new ListData();
        if (is_array($items)){
            $listData->options = $items;
            $listData->normalizeOptions();
        }
        else {
            $listData = $items;
        }
        
        // If attribute has a value use that as selected item/items
        if ($model->$attribute){
            $value = $model->$attribute;
            if (is_array($value)){
                foreach($value as $item ) $listData->setSelected ($item, true);
            }
            else {
                $listData->setSelected ($value, true);
            }
        }
        else {
            // Selected items can be passed as 'selectedItem' or 'selectedItems'
            $selectedItems = array_key_exists( "selectedItems", $options ) ? $options["selectedItems"] : array();
            $selectedItems = array_key_exists( "selectedItem", $options ) ? array($options["selectedItem"]) : $selectedItems;
            foreach($selectedItems as $item ) $listData->setSelected ($item, true);
        }
        
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $multiple = array_key_exists( "multiple", $htmlOptions ) &&  $htmlOptions['multiple'];
        if ( !array_key_exists( "id", $htmlOptions ) ){
            $htmlOptions['id'] =  CHtml::activeId($model, $attribute);
        }
        if ( !array_key_exists( "name", $htmlOptions ) ){
            $htmlOptions['name'] =  CHtml::activeName($model, $attribute);
            if ($multiple) $htmlOptions['name'] .= "[]";
        }
        $pluginOptions = array_key_exists( "pluginOptions", $options ) ? $options["pluginOptions"] : array();
        
        return $this->owner->widget("ext.yiigems.widgets.chosen.ChosenField", array(
            'listData' => $listData,
            'htmlOptions' => $htmlOptions,
            'pluginOptions' => $pluginOptions,
        ), true);
    }
    
    public function autoComplete($model, $column, $options = null) {
        $options = $options? $options : $this->owner->computeElementOptions($model, $column, "autoComplete");
        $source = array_key_exists( "source", $options ) ? $options["source"] : array( "Source Not Given");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $pluginOptions = array_key_exists( "pluginOptions", $options ) ? $options["pluginOptions"] : array();

        return Yii::app()->controller->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'name'=>get_class($model) . "[$column]",
                'value'=>$model->$column,
                'source'=>$source,
                'options'=>$pluginOptions,
                'htmlOptions'=>$htmlOptions
        ), true);
    }
}

?>
