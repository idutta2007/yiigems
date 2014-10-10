<?php

/**
 * LinkContainerBehavior to render a list of links that allows navigation, action
 * or form submission. The $item passed to renderItem has the following form
 * array(
 *     'itemType' => link, action or submit
 *     'labelMarkup' => The markup for the label
 *     'url' => The url of the link
 *     'anchorOptions' => The options for the anchor element (must have an id)
 *     'confirmMessage' = > The confirmation message,
 *     'script' => The script to be executed,
 *     'formSelector' => jquery selector for the form to be submitted,
 * )
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common.behave
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class LinkContainerBehavior extends CBehavior {
    protected function renderItem($item){
        $itemType = array_key_exists('itemType', $item) ? $item['itemType'] : "link";
        if ( $itemType == "link"){
            $this->renderLinkItem($item);
        }
        else if ( $itemType == "action"){
            $this->renderActionItem($item);
        }
        else if ( $itemType == "submit"){
            $this->renderSubmitItem($item);
        }
    }
    
    protected function renderLinkItem($item){
        // First render the link
        $label  = $this->getItemLabelMarkup($item);
        $url = $this->getItemUrl($item);
        $options = $this->getAnchorOptions($item);
        echo CHtml::link( $label, $url, $options );
        
        // Confirm link navigation if there is a confirmMessage
        $confirmMessage = $this->getItemConfirmationMessage($item);
        if ( $confirmMessage){
            $linkId = array_key_exists('id', $options)? $options['id'] : null;
            if ($linkId) {
                $con = Yii::app()->controller;
                $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
                $dlg->confirmLinkNavigation("#$linkId", $confirmMessage);
            }
        }
    }
    
    protected function renderActionItem($item){
        // First render the link
        $label  = $this->getItemLabelMarkup($item);
        $url = $this->getItemUrl($item);
        $options = $this->getAnchorOptions($item);
        echo CHtml::link( $label, $url, $options );
        
        // If script is not set return
        $script = array_key_exists('script', $item)? $item['script'] : null;
        if ( !$script ) return;
        
        // If link id is not set return
        $linkId = array_key_exists('id', $options)? $options['id'] : null;
        if ( !$linkId ) return;
        
        // Confirm action if there is a confirmation message
        $confirmMessage = $this->getItemConfirmationMessage($item);
        if ( $confirmMessage ){
            $con = Yii::app()->controller;
            $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
            $dlg->confirmAction( "#$linkId", $confirmMessage, $script);
        }
        else {
            Yii::app()->clientScript->registerScript( UniqId::get("scr-"), "
                $('#$linkId').click( function(ev){
                    $script
                });
            ");
        }
    }
    
    protected function renderSubmitItem($item){
        // First render the link
        $label  = $this->getItemLabelMarkup($item);
        $url = $this->getItemUrl($item);
        $options = $this->getAnchorOptions($item);
        echo CHtml::link( $label, $url, $options );
        
        // Get the form selector
        $formSel = array_key_exists('formSelector', $item)? $item['formSelector'] : "";
        
        // If link id is not set return
        $linkId = array_key_exists('id', $options)? $options['id'] : null;
        if ( !$linkId ) return;
        
        // Confirm submit if there is a confirmation message
        $confirmMessage = $this->getItemConfirmationMessage($item);
        if ( $confirmMessage ){
            $con = Yii::app()->controller;
            $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
            $dlg->confirmFormSubmission( "#$linkId", $formSel, $confirmMessage );
        }
        else {
            Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
                $('#$linkId').click( function(ev){
                    var form = $('#$linkId').closest('form');
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
    }
    
    protected function removeInvisibleItems($items){
        $result = array();
        foreach ($items as $item ) {
            $visible = array_key_exists('visible', $item) ? $item['visible'] : true;
            if ( $visible ){
                $result[] = $item;
            }
        }
        return $result;
    }
    
    protected function getItemLabelMarkup($item){
        return array_key_exists('labelMarkup', $item) ? $item['labelMarkup'] : "";
    }
    
    protected function getItemUrl($item){
        return array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
    }
    
    protected function getAnchorOptions($item){
        return array_key_exists('anchorOptions', $item) ? $item['anchorOptions'] : "";
    }
    
    protected function getItemConfirmationMessage($item){
        return array_key_exists('confirmMessage', $item) ? $item['confirmMessage'] : null;
    }
}

?>
