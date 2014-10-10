<?php

/**
 * An widget to display a set of links on a ribbon bar.
 * The RibbonMenu widget allows you to create a set of links on a ribbon bar much like a button bar or button stack
 * widget. It provides the same functionality as a RibbonText widget except that it allows you to specify a set of
 * links.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.ribbon
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.ribbon.RibbonMenuDefaults");
Yii::import("ext.yiigems.widgets.ribbon.AbstractRibbon");

class RibbonMenu extends AbstractRibbon {
    public $fontSize;

    /**
     * @var string the icon used for each menu item in the ribbon.
     */
    public $defaultIconClass;

    /**
     * @var string the banner text to be displayed just before the links.
     */
    public $banner;

    /**
     * @var array specifies the set of licks to be displayed on the RibbonMenu.
     */
    public $items = array();

    /**
     * @var array HTML options for the list element that contains the menu items.
     */
    public $listOptions = array();

    /**
     * @var array HTML options for the list item which holds the anchor.
     */
    public $itemOptions = array();

    /**
     * @var array the options for each anchor on the menu.
     */
    public $anchorOptions = array();

    /**
     * @var string the name of the skin class for this widget.
     */
    public $skinClass = "RibbonMenuDefaults";

    /**
     * @return array returns the list of properties to be copied from the active skin class.
     */
    public function getCopiedFields(){
        return array_merge( parent::getCopiedFields(), array(
            "fontSize", "defaultIconClass"
        ));
    }

    /**
     * @return array the list of properties to be merged from the skin class.
     */
    public function getMergedFields(){
        return array(
            "options", "listOptions", "itemOptions", "anchorOptions"
        );
    }

    /**
     * Initializes this widget by registering assets and generating all required markups.
     */
    public function init(){
        parent::init();
        $this->renderBanner();
        $this->renderLinks();
    }

    /**
     * Renders the banner that is displayed at the start of the menu.
     */
    public function renderBanner(){
        if ( $this->banner){
            echo $this->banner;
        }
    }

    /**
     * Renders the links in the menu bar.
     */
    public function renderLinks(){
        echo CHtml::openTag( "ul", $this->getListOptions());
        foreach( $this->items as $item ){
            $this->renderItem($item);
        }
        echo CHtml::closeTag("ul");
    }

    /**
     * Renders an item in the menu.
     * @param $item specifies an item to be rendered.
     */
    protected function renderItem($item){
        echo CHtml::openTag("li", $this->getItemOptions($item));
        $label = $this->getLabel($item);
        $url = array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
        echo CHtml::link( $label, $url, $this->getAnchorOptions($item));
        echo CHtml::closeTag("li");
    }

    /**
     * @return array list of options for the list containing the menu items.
     */
    private function getListOptions(){
        $style = StyleUtil::createStyle(array(
            'height'=>$this->height,
            'line-height'=>$this->height,
        ));
        $options = array(
            'style'=>$style
        );
        return array_merge( $options, $this->listOptions );
    }

    /**
     * @param $item  specifies a menu item.
     * @return array the HTML options for menu item.
     */
    protected function getItemOptions($item){
        return $this->itemOptions;
    }

    /**
     * @param $item specifies a menu item.
     * @return array the HTML options for the anchor item.
     */
    private function getAnchorOptions($item){
        $class = "";
        
        $options = array_key_exists( "options", $item ) ? $item['options'] : array();
        if ( $this->barGradient ){
            $class = "color_$this->barGradient hover_color_$this->barGradient active_color_$this->barGradient";
        }
        if ( $this->fontSize ){
            $class .= " $this->fontSize";
        }
        $options['class'] = $class;
        return array_merge($this->anchorOptions, $options);
    }

    /**
     * @param $item  specifies a menu item.
     * @return string the label associated with a menu item.
     */
    public function getLabel($item){
        $labelText = $item['label'];
        
        // Check to see if a specific icon set
        if(array_key_exists("iconClass", $item )){
            $iconClass = $item['iconClass'];
            return "<span class='$iconClass'></span>$labelText";
        }
        
        // Else use default icon if one is set
        else if($this->defaultIconClass){
            return "<span class='$this->defaultIconClass'></span>$labelText";
        }
        
        return $labelText;
    }
}

?>
