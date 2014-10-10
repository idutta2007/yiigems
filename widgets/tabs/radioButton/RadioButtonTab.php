<?php

/**
 * Example usage from a view.
 * 
 * <pre>
 * 
 *$this->widget("application.widgets.tabs.radioButton.RadioButtonTab", array(
 *  'name' => 'payType',
 *  'selectedItem'=>'card',
 *  'items' => array(
 *      'check'=>"Bank Check",
 *     'card'=>"Credit Card",
 *      'cash'=>"Cash",
 *  ),
 *  'buttonMap' => array(
 *      'check'=>"#check",
 *      'card'=>"#card",
 *      'cash'=>"#cash",
 *  ),
 *));
 * 
 * The HTML markup for the above widget is as follows:
 * 
 * <div id="check">
 *   Pay check here
 * </div>
 * <div id="card">
 *   Give me your credit card
 * </div>
 * <div id="cash">
 *    Pay cash here
 * </div>
 * 
 * </pre>
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.tabs.radiButton
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class RadioButtonTab extends CWidget {
    public $id = null;
    public $name = null;
    public $textStyle = "margin-left:0.5ex; margin-right:2ex";
    public $items = array();
    public $buttonMap = array();
    public $idMap = array();
    public $selectedItem = null;
    
    public function init() {
        if ( $this->id == null ) $this->id = UniqId::get("tab-");
        if ( $this->name == null ) $this->name = UniqId::get( "rbtn-");
        
        echo CHtml::openTag( "div", array('class'=>'radioButtonTab', 'id'=>$this->id));
        
        // Add the radio buttons
        foreach( $this->items as $value=>$label ){
            $inputId = UniqId::get("inp-");
            $this->idMap[$value] = $inputId;
            echo CHtml::tag( "input", array(
                'id'=>$inputId,
                'type'=>'radio',
                'value'=>$value,
                'name'=>$this->name,
            )); 
            echo CHtml::openTag( "span", array('style'=>$this->textStyle));
            echo $label;
            echo CHtml::closeTag( "span" );
        }
        echo CHtml::closeTag( "div" );
    }

    public function run() {
       $this->registerScript();
    }

    public function registerScript(){
        $contents = array();
        $jsMap = array();
        foreach( $this->buttonMap as $buttonValue=>$elemId ){
            $buttonId = $this->idMap[$buttonValue];
            $contents[] = $elemId;
            $jsMap[] = "'$buttonId' : '$elemId'";
        }
        $allContents = implode( ",", $contents );
        $js = implode( ",", $jsMap );
        $selectedItem = CHtml::encode($this->selectedItem);
        
        Yii::app()->clientScript->registerScript( $this->id, "
            $(document).ready(function(){
               $('$allContents' ).hide();
               $( '#$this->id input[type=radio]' ).click(function(){
                   var buttonId = $(this).attr('id' );
                   var map = { $js };
                   var contentSelector = map[buttonId];
                   $('$allContents' ).hide().removeClass('selected');
                   if ( contentSelector != null ){
                      $(contentSelector).show().addClass('selected');
                   }
               });
               $( '#$this->id input[value=\"$selectedItem\"]' ).click();
            });
        ");
    }
}

?>
