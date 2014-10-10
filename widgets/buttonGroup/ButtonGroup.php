<?php

/**
 * The base class for any widget that holds a group of buttons.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttonGroup
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class ButtonGroup extends AppWidget {
    /**
     * The HTML tag name for the list in the button group.
     * @var string
     */
    public $containerTag;

    /**
     * The HTML tag name for the list in the button group.
     * @var string 
     */
    public $listTag;
    
    /**
     * The HTML tag name for the individual buttons.
     * @var string 
     */
    public $itemTag;
    
    /**
     *The name of the background gradient to be used by the buttons. 
     * @var string 
     */
    public $gradient;
    
    /**
     * The name of the hover gradient to be used the buttons.
     * If hover gradient is not specified, an appropriate gradient with different
     * brightness is automatically used.
     * @var string 
     */
    public $hoverGradient;
    
    /**
     * The name of the active gradient to be used for the buttons.
     * If this value is not specified, an appropriate gradient with different
     * brightness is automatically used.
     * @var string 
     */
    public $activeGradient;
    
    /**
     * Specifies the gradient to be used for the selected button.
     * If the selected gradient is not specified, the framework used a default
     * gradient which always may not look pretty.
     * @var string 
     */
    public $selectedGradient;
    
    /**
     * Background color to be used for the selected button.
     * If this property is set, it will take precedence over selectedGradient
     * property.
     * @var string 
     */
    public $selectedBackgroundColor;
    
    /**
     * The color of the text for the selected button.
     * If this not provided,, the text color is computed based on the selected
     * gradient.
     * @var string 
     */
    public $selectedColor;
    
    /**
     * @var boolean Whether to display shadow for the entire button group.
     */
    public $displayShadow;
    
    /**
     * The direction of shadow of the button group.
     * See {@link http://yiigems.com/docs/api/extras/enumValues.html}
     * for all possible values.
     * @var string 
     */
    public $shadowDirection;
    
    /**
     * Specifies whether the shadow displayed should be colored.
     * @var string 
     */
    public $coloredShadow;
    
    /**
     * The round style of the button group.
     * See {@link http://lyiigems.com/gemsdoc/api/extras/enumValues.html} 
     * for all possible values.
     * @var string 
     */
    public $roundStyle;
    
    /**
     * The size of fonts to be used by the buttons in this group.
     * This value can be null in which case the font size will be inherited from
     * the parent element on the web page.
     * See {@link http://yiigems.com/docs/api/extras/enumValues.html}
     * for all possible values.
     * @var string 
     */
    public $fontSize;
    
    /**
     * The icon name to be displayed on left of each button.
     * @var string 
     */
    public $defaultLeftIconClass;

    /**
     * The icon name to be displayed on right of each button.
     * @var string
     */
    public $defaultRightIconClass;
    
    /**
     * The specification of list of buttons in the button group.
     * A button can be a link, an action button or a form submit button. An action
     * button will execute a javascript provided during its creation.
     * @var array 
     */
    public $items = array();
    
    /**
     * The HTML options for the container element of the button group.
     * @var array 
     */
    public $containerOptions = array();
    
    /**
     * The HTML options of the list that contains the buttons.
     * @var array 
     */
    public $listOptions = array();
    
    /**
     * The HTML options for each list item in the button group.
     * @var array 
     */
    public $itemOptions = array();
    
    /**
     * HTML options for the anchor element in a button.
     * @var array 
     */
    public $anchorOptions = array();
    
    /**
     * Sets up the default values for button group properties. 
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get( "bgroup-");

        if(!$this->hoverGradient) $this->hoverGradient = GradientUtil::getHoverGradient($this->gradient);
        if(!$this->activeGradient) $this->activeGradient = GradientUtil::getActiveGradient($this->gradient);
        if(!$this->selectedGradient) $this->selectedGradient = GradientUtil::getSelectedGradient($this->gradient);

        // Remove invisible items
        $this->items = $this->removeInvisibleItems($this->items);

        // set defaults for each item
        foreach( $this->items as &$item ){
            $this->setItemDefaults($item);
        }
    }

    protected function setItemDefaults( &$item){
        if ( !array_key_exists('id', $item))  $item['id'] = UniqId::get( "itm-");
        if ( !array_key_exists('itemType', $item))  $item['itemType'] = "link";
        if ( array_key_exists('selected', $item) && $item['selected'])  $item['target'] = "javascript:void(0)";
        if ( !array_key_exists('target', $item))  $item['target'] = "javascript:void(0)";
        if ( !array_key_exists('leftIconClass', $item))  $item['leftIconClass'] = $this->defaultLeftIconClass;
        if ( !array_key_exists('rightIconClass', $item))  $item['rightIconClass'] = $this->defaultRightIconClass;
    }
    
    /**
     * @return array the list of properties to be assigned from skin class.
     */
    protected function getCopiedFields(){
        return array(
            "containerTag", "listTag", "itemTag",
            "gradient", "hoverGradient", "activeGradient", "selectedGradient",
            "selectedBackgroundColor", "selectedColor", 
            "displayShadow", "shadowDirection", "coloredShadow",
            "roundStyle", "fontSize", "defaultLeftIconClass", "defaultLeftIconClass",
        );
    }
    
    /**
     * @return array the list of array properties to be merged from skin class.
     */
    protected function getMergedFields(){
        return array(
           "containerOptions", "listOptions", "itemOptions", "anchorOptions"
        );
    }
    
    /**
     * Returns the label for the button
     * @param $item specifies a button.
     * @return string 
     */
    public function getLabel($item){
        $labelText = $item['label'];
        
        // Set the left icon
        if(array_key_exists("leftIconClass", $item )){
            $iconClass = $item['leftIconClass'];
            $labelText = "<span class='$iconClass'></span> $labelText";
        }
        else if($this->defaultLeftIconClass){
            $labelText = "<span class='$this->defaultLeftIconClass'></span> $labelText";
        }

        // Set the right icon
        if(array_key_exists("rightIconClass", $item )){
            $iconClass = $item['rightIconClass'];
            $labelText = "<span class='$iconClass'></span> $labelText";
        }
        else if($this->defaultRightIconClass){
            $labelText = "$labelText <span class='$this->defaultRightIconClass'></span>";
        }
        return $labelText;
    }
    
    /**
     * The HTML options for an HTML list item.
     * Derived classes should override this method to return the appropriate
     * lst of options.
     * @param array $item specifies a button in the button group.
     * @param integer $index is the position of the button in the group.
     * @param integer $count total number of buttons in the group.
     * @return null derived classes should return an array. 
     */
    protected function getItemOptions($item, $index, $count){
        return null;
    }
    
    /**
     * The HTML options for the anchors.
     * Derived classes should override this method to return the appropriate
     * lst of options.
     * @param array $item specifies a button in the button group.
     * @param integer $index is the position of the button in the group.
     * @param integer $count total number of buttons in the group.
     * @return null derived classes should return an array. 
     */
    protected function getAnchorOptions($item, $index, $count){
        return null;
    }
    
    /**
     * Removes any invisible items from the button group.
     * @param array $items List of buttons in the button group.
     * @return array the list of visible buttons in the group. 
     */
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
}
?>
