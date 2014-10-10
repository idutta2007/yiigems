<?php

/**
 * The base class for widgets that displays a list of links to be displayed on the side of a web page.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.sidebarMenu
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class AbstractSidebarMenu extends AppWidget {
    /**
     * @var string the container tag to be used to render this widget - defaults to "ul".
     */
    public $containerTag;


    /**
     * @var string the  tag to be used to render the list in this widget.
     */
    public $listTag;

    /**
     * @var string the tag to be used to render each item in the menu - defaults to "li".
     */
    public $itemTag;

    /**
     * @var array HTML options for the container element of the widget.
     */
    public $containerOptions = array();

    /**
     * @var array HTML options for the list in the menu.
     */
    public $listOptions = array();

    /**
     * @var array HTML options for the list items in the menu.
     */
    public $itemOptions = array();

    /**
     * @var array HTML options for anchor elements.
     */
    public $anchorOptions = array();

    /**
     * @var string the gradient to be used used a background for each item.
     */
    public $gradient = null;

    /**
     * @var string the name of the hoverGradient to be used.
     * If this property is not set it computed from the property $gradient.
     */
    public $hoverGradient = null;

    /**
     * @var string the name of the activeGradient for each item.
     * If this property is not set it is computed from the property $gradient.
     */
    public $activeGradient = null;

    /**
     * @var string the font size for each item.
     */
    public $fontSize = null;

    /**
     * @var string the round style of each item.
     */
    public $roundStyle = null;

    /**
     * @var string the color of the divider between two items.
     */
    public $dividerColor = null;

    /**
     * @var array the list of items to be rendered as links.
     */
    public $items = array();

    /**
     * @var string the CSS class for the container element.
     */
    public $navClass;

    /**
     * @var string the name of the primary CSS file to be used by widget.
     */
    public $cssFile;

    /**
     * @var string the name of the icon class to be used by this widget on left.
     */
    public $leftIconClass;

    /**
     * @var string the name of the icon class to be used by this widget on right.
     */
    public $rightIconClass;

    public function getCopiedFields(){
        return array(
            "containerTag", "listTag", "itemTag",
            "gradient", "hoverGradient", "activeGradient",
            "fontSize", "roundStyle", "dividerColor",
            "leftIconClass", "rightIconClass"
        );
    }

    public function getMergedFields(){
        return array( "containerOptions", "listOptions", "itemOptions", "anchorOptions");
    }

    protected function setMemberDefaults(){
        parent::setMemberDefaults();

        if (!$this->hoverGradient)  $this->hoverGradient = GradientUtil::getHoverGradient ($this->gradient);
        if (!$this->activeGradient)  $this->activeGradient = GradientUtil::getActiveGradient ($this->gradient);
    }

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            $this->cssFile,
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets(array($this->gradient, $this->hoverGradient, $this->activeGradient));
    }

    /**
     * Initializes this widget by registering all assets and generating markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( $this->containerTag, $this->getContainerOptions());
        echo CHtml::openTag($this->listTag, $this->getListOptions());
        
        // Remove invisible items
        $items = $this->removeInvisibleItems($this->items);
        
        // Render the items
        $count = count($items);
        foreach ($items as $index=>$item ) {
            $itemType = array_key_exists("itemType", $item ) ? $item['itemType'] : "link";
            if ($itemType == "link") {
                $this->renderAnchorItem($item, $index, $count);
            } 
            else if ($itemType == "action") {
                $this->renderActionItem($item, $index, $count);
            }
        }
        echo CHtml::closeTag($this->listTag);
        echo CHtml::closeTag($this->containerTag );
    }

    /**
     * @param $items list of items to be displayed by this widget.
     * @return array return a new list after removing all invisible items.
     */
    private function removeInvisibleItems($items){
        $result = array();
        foreach ($items as $item ) {
            $visible = array_key_exists('visible', $item) ? $item['visible'] : true;
            if ( $visible ){
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * @param $item specifies the item to be rendered.
     * @param $index specifies the position of the item in the menu.
     * @param $count specifies total number of items in the menu.
     * @return array the effective HTML options used by the item.
     */

    protected function renderAnchorItem($item, $index, $count){
        $options = $this->getAnchorOptions($item, $index, $count);
        
        echo CHtml::openTag("li", $this->getItemOptions($item, $index, $count));
        
        $label = $this->getLabelMarkup($item);
        $url = array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
        echo CHtml::link( $label, $url, $options);
        echo CHtml::closeTag("li");
        return $options;
    }

    /**
     * @param $item specifies the item to be rendered.
     * @param $index specifies the position of the item in the menu.
     * @param $count specifies total number of items in the menu.
     * @return array the effective HTML options used by an action item.
     */
    protected function renderActionItem($item, $index, $count){
        $options = $this->renderAnchorItem($item, $index, $count);
        $linkId = $options['id'];
        
        $script = array_key_exists( "script", $item ) ? $item['script'] : "javascript:void(0)";
        
        Yii::app()->clientScript->registerScript( UniqId::get( "scr-"), "
            $('#$linkId').click( function(ev){
                $script
            });
        ");
        return $options;
    }

    /**
     * @return array the HTML options used by the container element.
     */
    private function getContainerOptions(){
        $options = $this->containerOptions;
        $options['class'] = $this->navClass;
        $options['id'] = $this->id;
        return $options;
    }

    /**
     * @return array the HTML options used by the list tag.
     */
    private function getListOptions(){
        return $this->listOptions;;
    }

    /**
     * @@param $item specifies the item to be rendered.
     * @param $index specifies the position of the item in the menu.
     * @param $count specifies total number of items in the menu.
     * @return array the HTML options used by the list item.
     */
    protected function getItemOptions($item, $index, $count){
        $options = $this->itemOptions;
        $class = "";
        if ( $this->fontSize ) $class = "$this->fontSize";
        if ( $class ) $options['class'] = $class;
        $options['style'] = "border-color:$this->dividerColor";
        return $options;
    }

    /**
     * @@@param $item specifies the item to be rendered.
     * @param $index specifies the position of the item in the menu.
     * @param $count specifies total number of items in the menu.
     * @return array the HTML options used by the anchor element.
     */
    protected function getAnchorOptions($item, $index, $count){
        $options = array_key_exists( "options", $item ) ? $item['options'] : array();
        $options = array_merge($this->anchorOptions, $options);
        $options['id'] =  array_key_exists("id", $options) ? $options['id'] : UniqId::get("vbtn-");
        
        //$cssClass = array_key_exists( "addClass", $item ) ? $item['options'] : "";
        $cssClass = "background_{$this->gradient}";
        $cssClass .= " color_{$this->gradient}";
        $cssClass .= " hover_background_{$this->hoverGradient}";
        $cssClass .= " hover_color_{$this->hoverGradient}";
        $cssClass .= " active_background_{$this->activeGradient}";
        $cssClass .= " active_color_{$this->activeGradient}";
        
        // Add round style
        if ( $this->roundStyle ) $cssClass .= " $this->roundStyle";
        
        // add additonal class if given
        if ( array_key_exists( "addClass", $item ) ) $cssClass .= " " . $item['addClass'];
        
        $options['class'] = $cssClass;
        return $options;
    }
    
    public function getLabelMarkup($item){
        $label = $item['label'];

        // Add icon on left
        if ($this->leftIconClass){
            $label = "<span class='$this->leftIconClass'></span> " . $label;
        }
        else if (array_key_exists("leftIconClass", $item)){
            $leftIconClass = $item['leftIconClass'];
            $label = "<span class='$leftIconClass'></span> " . $label;
        }

        // Add icon on right
        if ($this->rightIconClass){
            $label = $label . " <span class='$this->rightIconClass'></span>";
        }
        else if (array_key_exists("rightIconClass", $item)){
            $rightIconClass = $item['rightIconClass'];
            $label = $label . " <span class='$rightIconClass'></span>";
        }

        return $label;
    }
}

?>
