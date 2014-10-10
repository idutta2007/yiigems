<?php

/**
 * The skin class for ActiveModelForm widget.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class ActiveModelFormDefaults {
    public static $containerTag = "div";
    public static $containerOptions = array();
    public static $formOptions = array();
    public static $submitSectionRulerStyle = "height:1px;border-top:1px dotted black;margin-top:0.5em;margin-bottom:0.5em";
    public static $submitIconClass;
    public static $submitButtonLabel = "Save";
    public static $submitConfirmMessage;
    public static $addInvisibleSubmitButton = true;
    
    public static $formConfig = array(
        'label' => array(
             'htmlOptions' => array()
        ),
        'textField'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'maskedInputField'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'integerField'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'decimalField'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'telephoneField'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'emailField'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'passwordField'=>array(
            'htmlOptions' => array('class'=>'small_round' )
        ),
        'textArea'=>array(
            'htmlOptions' => array('class'=>'small_round' )
        ),
        'fileField'=>array(
            'htmlOptions' => array('class'=>'small_round' )
        ),
        'datePicker'=>array(
            'htmlOptions' => array('class'=>'small_round', 'style'=>'height:auto;' )
        ),
        'timePicker'=>array(
            'htmlOptions' => array('class'=>'small_round' )
        ),
        'dropdownList'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'listBox'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'monthPicker'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'yearPicker'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        'monthYearPicker'=>array(
            'htmlOptions' => array( 'class'=>'small_round' )
        ),
        
        // Defaults related to input groups
        'textFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'passwordFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'textAreaGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'checkBoxGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'radioButtonGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'fileFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'dropdownListGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'listBoxGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'checkBoxListGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'radioButtonListGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'integerFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'decimalFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'telephoneFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'emailFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'maskedInputFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'chosenFieldGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'datePickerGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'timePickerGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'monthPickerGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'yearPickerGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
        'monthYearPickerGroup' => array(
            'roundStyle' => 'small_round',
            'leftContent' => array( 'type'=>'icon', 'iconClass' => "icon-pencil" )
        ),
    );
}
?>
