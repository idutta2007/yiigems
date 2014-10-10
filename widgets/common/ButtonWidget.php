<?php

/**
 * Base class for all button widgets.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */


Yii::import("ext.yiigems.widgets.common.AppWidget");

class ButtonWidget extends AppWidget{
    public $buttonType = "link";
    public $label = "Not Set";
    public $url = "javascript:void(0)";
    public $options = array();
    public $script = "javascript:void(0)";
    public $submitHandlerCode = "";
    public $formSelector = "";
    public $confirmMessage;
    
    /**
     * @return string the label for the button. 
     */
    protected function getLabel(){
        return $this->label;
    }
    
    /**
     * Renders the HTML link for the button.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderLink($options){
        if ( $this->confirmMessage ){
            echo CHtml::link( $this->getLabel(), $this->url, $options );
            
            // Create the script to prompt before action
            $stringUrl = CHtml::normalizeUrl($this->url);
            $dlg = Yii::app()->controller->widget("ext.yiigems.widgets.impromptu.Impromptu");
            $confirmScript = $dlg->getConfirmationPopupScript($this->confirmMessage, "function(v,m,f){
                if (v==null || v==false) return;
                window.location = '$stringUrl';
            }");
            
            // display confirmation on click
            $buttonId = $options['id'];
            Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
                $('#$buttonId').click( function(ev){
                  $confirmScript
                  ev.preventDefault();
                  return false;
                });
            ");
        }
        else {
            echo CHtml::link( $this->getLabel(), $this->url, $options );
        }
    }
    
    /**
     * Renders action  button which call a script on click.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderActionButton($options){
        if ( $this->confirmMessage ){
            $this->renderConfirmedActionButton($options);
        }
        else {
            $this->renderUnconfirmedActionButton($options);
        }
    }
    /**
     * Renders an action button that does not require confirmation.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderUnconfirmedActionButton($options){
        echo CHtml::link( $this->getLabel(), "javascript:void(0)", $options );
        $buttonId = $options['id'];
        Yii::app()->clientScript->registerScript( UniqId::get("scr-") , "
            $('#$buttonId').click( function(ev){
                $this->script
            });
        ");
    }
    
    /**
     * Renders an action button that requires confirmation.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderConfirmedActionButton($options){
        echo CHtml::link( $this->getLabel(), "javascript:void(0)", $options );
        
        // Create the script to prompt before action
        $dlg = Yii::app()->controller->widget("ext.yiigems.widgets.impromptu.Impromptu");
        $confirmScript = $dlg->getConfirmationPopupScript($this->confirmMessage, "function(v,m,f){
            if (v==null || v==false) return;
            $this->script
        }");
        
        // Call the confirmation script when button is clicked
        $buttonId = $options['id'];
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            $('#$buttonId').click( function(ev){
              $confirmScript
              ev.preventDefault();
              return false;
            });
        ");
    }
    
    /**
     * Renders an submit button.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderSubmitButton($options){
        if ( $this->confirmMessage ){
            $this->renderConfirmedSubmitButton($options);
        }
        else {
            $this->renderUnconfirmedSubmitButton($options);
        }
    }
    
    /**
     * Renders an submit button that does not require confirmation.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderUnconfirmedSubmitButton($options){
        echo CHtml::link( $this->getLabel(), "javascript:void(0)", $options );
        
        $buttonId = $options['id'];
        $form = $this->formSelector ? "$('$this->formSelector')" : "$('#$buttonId').closest('form')";
        $submitHandlerCode = $this->submitHandlerCode ? "$form.submit(function(){
            $this->submitHandlerCode
        });" : "";
        Yii::app()->clientScript->registerScript(UniqId::get("src-"), "
            $submitHandlerCode
                  
            $('#$buttonId').click( function(ev){
              if ( $form.length > 0 ){
                  $form.submit();
              }
              else {
                  alert('No form found to submit');
              }
              ev.preventDefault();
              return false;
            });
        ");
    }
    
    /**
     * Renders an submit button that requires confirmation.
     * @param array $options specifies the HTML options for the anchor.
     */
    protected function renderConfirmedSubmitButton($options){
        // First create the link
        echo CHtml::link( $this->getLabel(), "javascript:void(0)", $options );
        
        // Get button id and the form selector
        $buttonId = $options['id'];
        $formSel = $this->formSelector ? $this->formSelector : "";
        
        // Create the script to prompt before form submit.
        $dlg = Yii::app()->controller->widget("ext.yiigems.widgets.impromptu.Impromptu");
        $warningScript = $dlg->getWarningPopupScript( "Form submission Failed" );
        
        $confirmScript = $dlg->getConfirmationPopupScript($this->confirmMessage, "function(v,m,f){
            if (v==null || v==false) return;
            var form = $('#$buttonId').closest('form');
            if ( '$formSel' != '' ) form = $('$formSel');
            if ( form.length > 0 ){
               form.submit();
            }
            else {
               $warningScript
            }
         }");
        
        
        // Call the confirmation script when button is clicked
        Yii::app()->clientScript->registerScript(UniqId::get("src-"), "
            $('#$buttonId').click( function(ev){
              $confirmScript
              ev.preventDefault();
              return false;
            });
        ");
        
        // Call submit handler when form is submitted
        Yii::app()->clientScript->registerScript(UniqId::get("src-"), "
            var form = $('#$buttonId').closest('form');
            if ( '$formSel' != '' ) form = $('$formSel');
            if ( form.length > 0 ){
               form.submit(function(){
                  $this->submitHandlerCode;
               });
            }
        ");
    }
    
    public function renderLinkTag($options){
        echo CHtml::openTag($this->htmlTag, $options);
        $tagId = $options['id'];
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            $('#$tagId').click( function(ev){
                window.location = '$this->url';
            });
        ");
    }
    
    public function renderSubmitTag($options){
        echo CHtml::openTag($this->htmlTag, $options);
        $buttonId = $options['id'];
        $formSel = $this->formSelector ? $this->formSelector : "";
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            $('#$buttonId').click( function(ev){
              var form = $('#$buttonId').closest('form');
              if ( '$formSel' != '' ) form = $('$formSel');
              if ( form.length > 0 ){
                  form.submit();
              }
              else {
                  alert('No form found to submit');
              }
              ev.preventDefault();
              return false;
            });
        ");
    }
    
    public function renderActionTag($options){
        echo CHtml::openTag($this->htmlTag, $options);
        $tagId = $this->options['id'];
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            $('#$tagId').click( function(ev){
                $this->script
            });
        ");
    }
}

?>
