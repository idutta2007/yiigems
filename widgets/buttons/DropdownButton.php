<?php

/**
 * Description of DropDownButton
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttons
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.buttons.GradientButton");
Yii::import("ext.yiigems.widgets.buttons.DropdownButtonDefaults");
Yii::import("ext.yiigems.widgets.common.behave.LinkContainerBehavior");

class DropdownButton extends GradientButton {
    /**
     * @var array, the list of items in the dropdown. The formaty of the item 
     * element is as follows: 
     * array(
     *    'itemType' => link, action, submit or separator. Default is link.
     *    'url' = > url of the item as array or as string.
     *    'label' => the label for the element, text or html
     *    'iconClass' => The icon for the item.
     *    'script' => the javascript  to be executed if an action item.
     *    'formSelector' => if od the form if the item acts as form submit button.
     *    'confirmMessage' => message if action required confirmation.
     *    'htmlOptions' => htmlOptions for the item
     * )
     */
    public $items = array();
    
    /** The HTML options for the drop down container */
    public $dropdownContainerOptions = array();
    
    /** The default icon for the items in the dropdown list */
    public $dropdownItemIconClass;
    
    /** The down icon displayed on the dropdown button */
    public $downIconClass;
    
    /** The id of the popup containing the down down items */
    public $popupId;
    
    /** The hover background for the dropdown items */
    public $itemHoverBackground;
    
    /** 
     * The horizontal alignment of the drop down which is left, right or center 
     * The default is left.
     */
    public $popupAlignment = "left";
    public $popupRoundStyle;
    
    public $buttonCssFile = "dropdownBtn.css";
    public $buttonClass = "dropdownBtn";
    
    public $skinClass = "DropdownButtonDefaults";
    
    protected function getCopiedFields() {
        $result = parent::getCopiedFields();
        $result[] = "downIconClass";
        $result[] = "dropdownItemIconClass";
        $result[] = "dropdownItemIconClass";
        $result[] = "itemHoverBackground";
        return $result;
    }
    
    protected function getMergedFields() {
        $result = parent::getMergedFields();
        $result[] = "dropdownContainerOptions";
        return $result;
    }
    
    public function setupAssetsInfo() {
        parent::setupAssetsInfo();
        JQueryUI::registerYiiJQueryUIResources();
        $this->addAssetInfo( "dropdownBtn.js", dirname(__FILE__) . "/assets/common" );
        $this->addGradientAssets( array( $this->itemHoverBackground ));
    }
    
    public function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id =  $this->id ? $this->id : UniqId::get("ddb-");
        $this->popupId =  $this->popupId ? $this->popupId : UniqId::get("ddbp-");
    }
    
    public function getLabel(){
        if ( $this->iconClass ){
            return "<span class='$this->iconClass'></span> $this->label <span class='$this->downIconClass'></span>";
        }
        return "$this->label <span class='$this->downIconClass'></span>";
    }
    
    
    public function run(){
        parent::run();
        $this->renderDropdown();
        
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            if ( $('#yiigems').length == 0 ){
                $('<div id=\"yiigems\"></div>').appendTo('body');
            }
            $('#$this->popupId').appendTo('#yiigems');
                    
            $('#$this->id').dropdownButton({
                popupId: '$this->popupId',
                popupAlignment: '$this->popupAlignment'
            });
        ");
    }
    
    public function renderDropdown(){
        $this->attachBehavior("linkCintainer", new LinkContainerBehavior() );
        
        echo CHtml::openTag("ul", $this->getDropdownContainerOptions());
        foreach( $this->items as $item ){
           $itemType = array_key_exists("itemType", $item) ? $item['itemType']: "link";
           if ( $itemType == "separator"){
               echo CHtml::openTag("li", array('class'=>'separator'));
               echo "<hr/>";
               echo CHtml::closeTag("li" );
           }
           else {
               echo CHtml::openTag("li" );
               $item['labelMarkup'] = $this->getItemLabel($item);
               $item['anchorOptions'] = $this->getItemAnchorOptions($item);
               $this->renderItem($item);
               echo CHtml::closeTag("li" );
           }
        }
        echo CHtml::closeTag("ul");
    }

    public function getDropdownContainerOptions() {
        $cssClass = "btn-dropdown";
        
        // If popupround style is given use it. Other use the same round 
        // style as the button. This is useful in certain scenarios.
        if ($this->popupRoundStyle) {
            $cssClass .= " $this->popupRoundStyle";
        }
        else {
            $cssClass .= " $this->roundStyle";
        }
        if ($this->fontSize) $cssClass .= " $this->fontSize";
        
        $options = array(
            'id' => $this->popupId,
            'class' => $cssClass
        );
        return ComponentUtil::mergeHtmlOptions($options, $this->dropdownContainerOptions);
    }
    
    private function getItemLabel($item){
        $label = array_key_exists("label", $item) ? $item['label'] : "NoLabel";
        $iconClass = array_key_exists("iconClass", $item) ? $item['iconClass'] : $this->dropdownItemIconClass;
        
        if ($iconClass){
            return "<span class='$iconClass'></span> $label";
        }
        return $label;
    }
    
    private function getItemAnchorOptions($item){
        $htmlOptions = array_key_exists("htmlOptions", $item) ? $item['htmlOptions'] : array();
        if (!array_key_exists("id", $htmlOptions)){
            $htmlOptions['id'] = UniqId::get('lnk-');
        }
        if ( $this->itemHoverBackground ){
            $htmlOptions['class'] = "hover_background_$this->itemHoverBackground hover_color_$this->itemHoverBackground active_color_{$this->itemHoverBackground}a";
        }
        return $htmlOptions;
    }
}

?>
