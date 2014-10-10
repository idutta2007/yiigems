<?php

/**
 * Base class for all dropdown menu widgets.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class DropDownWidget extends AppWidget{
    /**
     * @var string The HTML tag to be used for the menu container element.
     * This defaults to an ul element. 
     */
    public $menuTag;
    
    /**
     * @var string The HTML tag to be used for a menu item container.
     * This defaults to li tag. 
     */
    public $itemTag;
    
    /**
     * @var string Specifies the icon to indicate a drop menu. 
     */
    public $dropMenuIconClass = "icon-chevron-sign-down pull-right";
    
    /**
     * @var string Specifies the icon to indicate a fly menu. 
     */
    public $flyMenuIconClass = "icon-chevron-sign-right pull-right";
    
    
    /**
     * @return array return HTML options for the menu container.
     */
    public function getMenuOptions(){ return array(); }
    
    /**
     * Returns the html options to be used for the specified drop menu item. 
     * @param array $menu specifies the drop menu item.
     * @return array HTML options for the drop menu item. 
     */
    public function getDropMenuOptions($menu){ return array(); }
    
    /**
     * Returns the html options to be used for the specified fly menu item. 
     * @param array $menu specifies the fly menu item.
     * @return array HTML options for the fly menu item. 
     */
    public function getFlyMenuOptions($menu){ return array(); }
    
    /**
     * Returns the HTML options for the menu item on the main menu.
     * @param array $item specifies a menu item
     * @return array HTML options for the menu item. 
     */
    public function getMenuItemOptions($item){ return array(); }
    
    /**
     * Returns the HTML options for the menu item on a drop menu.
     * @param array $item specifies a drop menu item
     * @return array HTML options for the drop menu item. 
     */
    public function getDropMenuItemOptions($item){ return array(); }
    
    
    /** Returns the HTML options for the separator possibly based widget properties */ 
    public function getDropMenuSeparatorOptions($item){ return array(); }
    
    /**
     * Returns the HTML options for the menu item on a fly menu.
     * @param array $item specifies a fly menu item
     * @return array HTML options for the fly menu item. 
     */
    public function getFlyMenuItemOptions($item){ return array(); }
    
    /** Returns the HTML options for the separator possibly based widget properties */ 
    public function getFlyMenuSeparatorOptions($item){ return array(); }
    
    /**
     * Returns the HTML options for the anchor on the main menu.
     * @param array $item specifies a item on the main menu.
     * @return array HTML options for the menu item. 
     */
    public function getMenuAnchorOptions($item, $index, $total){ return array(); }
    
    /**
     * Returns the HTML options for the anchor on a drop menu.
     * @param array $item specifies a item on a drop menu.
     * @return array HTML options for the menu item. 
     */
    public function getDropMenuAnchorOptions($item, $index, $total){ return array(); }
    
    /**
     * Returns the HTML options for the anchor on a fly menu.
     * @param array $item specifies a item on a fly menu.
     * @return array HTML options for the menu item. 
     */
    public function getFlyMenuAnchorOptions($item, $index, $total){ return array(); }
    
    /** Returns the HTML options for the search text box */
    public function computeSearchBoxOptions($item) { return array(); }
    
    /**
     * Renders all items in the dropdown menu.
     */
    public function createMenu() {
        $items = $this->removeInvisibleItems($this->items);
        $count = count($items);
        if ( $count == 0 ) return;
        
        echo CHtml::openTag($this->menuTag, $this->getMenuOptions());
        foreach ($items as $index=>$menu ) {
            if (array_key_exists("itemType", $menu) && $menu['itemType'] == "searchBox"){
                $this->createSearchBox($menu);
            }
            else if (array_key_exists("itemType", $menu) && ($menu['itemType'] == "strut" || $menu['itemType'] == "horzStrut")){
                $this->createHorizontalStrut($menu);
            }
            else {
                $this->createMenuItem($menu, $index, $count);
            }
        }
        
        echo CHtml::closeTag($this->menuTag);
    }
    
    public function createSearchBox($item){
        // Compute form options
        $formOptions = array_key_exists("formOptions", $item) ? $item['formOptions'] : array();
        $action = array_key_exists("action", $formOptions) ? $formOptions['action'] : "";
        $method = array_key_exists("method", $formOptions) ? $formOptions['method'] : "post";
        $options = array_key_exists("options", $formOptions) ? $formOptions['options'] : array();
        
        echo CHtml::openTag($this->itemTag, $this->getMenuItemOptions($item));
        echo CHtml::openTag("div", array(
            'style'=>'font-size:inherit;height:2.5em;margin-left:1em'
        ));
        
        echo CHtml::beginForm($action, $method, $options);
        echo CHtml::tag("input", $this->computeSearchBoxOptions($item) );
        echo CHtml::endForm();
        echo CHtml::closeTag("div");
        echo CHtml::closeTag($this->itemTag);
    }
    
    public function createHorizontalStrut($item){
        $options = $this->getMenuItemOptions($item);
        $style = array_key_exists("style", $options) ? $options['style'] : "";
        $style = StyleUtil::mergeStyles("display:inline-block;width:1em", $style);
        $options['style'] = $style;
        
        echo CHtml::openTag($this->itemTag, $options );
        echo CHtml::closeTag($this->itemTag);
    }
    
    /**
     * Renders the specified item on the main menu.
     * @param array $item specifies an item.
     * @param integer $index position of the item in the menu.
     * @param integer $total total number of items in the menu.
     */
    public function createMenuItem( $item, $index, $total) {
        $items = array_key_exists('items', $item) ? $item['items'] : array();
        $items = $this->removeInvisibleItems($items);
        
        echo CHtml::openTag($this->itemTag, $this->getMenuItemOptions($item));
        $this->createMenuAnchor($item, $index, $total);
        
        if ( count($items) > 0 ) $this->createDropMenu($item);
        
        echo CHtml::closeTag($this->itemTag);
    }
    
    /**
     * Renders the specified drop menu.
     * @param array $menu specifies a drop menu item.
     */
    public function createDropMenu($menu){
        echo CHtml::openTag($this->menuTag, $this->getDropMenuOptions($menu));
        
        $items = $menu['items'];
        $total = count($items);
        
        foreach ($items as $index=>$item) {
            if (array_key_exists("itemType", $item) && $item['itemType'] == "separator"){
                $this->createDropMenuSeparator($item, $index, $total);
            }
            else {
                $this->createDropMenuItem($item, $index, $total);
            }
        }
        echo CHtml::closeTag($this->menuTag);
    }
    
    public function createDropMenuSeparator($item, $index, $total) {
        $options = $this->getDropMenuSeparatorOptions($item);
        echo CHtml::openTag($this->itemTag, $options);
        echo CHtml::closeTag($this->itemTag );
    }

    /**
     * Renders the specified item on drop menu.
     * @param array $item specifies an item in a drop menu.
     * @param integer $index position of the item in the drop menu.
     * @param integer $total total number of items in the drop menu.
     */
    public function createDropMenuItem($item, $index, $total) {
        $items = array_key_exists('items', $item) ? $item['items'] : array();
        $items = $this->removeInvisibleItems($items);
        
        echo CHtml::openTag($this->itemTag, $this->getDropMenuItemOptions($item));
        $this->createDropMenuAnchor($item, $index, $total);
        
        if ( count($items) > 0 ) $this->createFlyMenu($item);
        
        echo CHtml::closeTag($this->itemTag );
    }
    
    
    /**
     * Renders the specified fly menu.
     * @param array $menu specifies a fly menu item.
     */
    public function createFlyMenu( $menu ) {
        echo CHtml::openTag($this->menuTag, $this->getFlyMenuOptions($menu));
        
        $items = $menu['items'];
        $total = count($items);
        
        foreach ($menu['items'] as $index=>$item) {
            if (array_key_exists("itemType", $item) && $item['itemType'] == "separator"){
                $this->createFlyMenuSeparator($item, $index, $total);
            }
            else {
                $this->createFlyMenuItem($item, $index, $total);
            }
        }
        echo CHtml::closeTag($this->menuTag);
    }

    /**
     * Renders the specified item on a fly menu.
     * @param array $item specifies an item in a fly menu.
     * @param integer $index position of the item in the fly menu.
     * @param integer $total total number of items in the fly menu.
     */
    public function createFlyMenuItem( $item, $index, $total ) {
        echo CHtml::openTag($this->itemTag, $this->getFlyMenuItemOptions($item));
        $this->createFlyMenuAnchor($item, $index, $total);
        
        $items = array_key_exists('items', $item) ? $item['items'] : array();
        $items = $this->removeInvisibleItems($items);
        
        if ( count($items) > 0 ) $this->createFlyMenu($item);
        
        echo CHtml::closeTag($this->itemTag );
    }
    
    public function createFlyMenuSeparator($item, $index, $total) {
        $options = $this->getFlyMenuSeparatorOptions($item);
        echo CHtml::openTag($this->itemTag, $options);
        echo CHtml::closeTag($this->itemTag );
    }
    
    //========================== Anchor creation ===============================
    
    /**
     * Renders the anchor element of menu item in the main menu.
     * @param array $item specifies an item in the main menu.
     * @param integer $index position of the item in the main menu.
     * @param integer $total total number of items in the main menu.
     */
    public function createMenuAnchor($item, $index, $total) {
        $label = $this->getItemLabel($item, $this->dropMenuIconClass);
        $url = array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
        echo CHtml::link($label, $url, $this->getMenuAnchorOptions($item, $index, $total));
    }
    
    /**
     * Renders the anchor element on a drop menu item.
     * @param array $item specifies an item in the drop menu.
     * @param integer $index position of the item in the drop menu.
     * @param integer $total total number of items in the drop menu.
     */
    public function createDropMenuAnchor($item, $index, $total) {
        $label = $this->getItemLabel($item, $this->flyMenuIconClass);
        $url = array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
        echo CHtml::link($label, $url, $this->getDropMenuAnchorOptions($item, $index, $total));
    }
    
    /**
     * Renders the anchor element on a fly menu item.
     * @param array $item specifies an item in the fly menu.
     * @param integer $index position of the item in the fly menu.
     * @param integer $total total number of items in the fly menu.
     */
    public function createFlyMenuAnchor($item, $index, $total) {
        $label = $this->getItemLabel($item, $this->flyMenuIconClass);
        $url = array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
        echo CHtml::link($label, $url, $this->getFlyMenuAnchorOptions($item, $index, $total));
    }
    
    /**
     * Returns the label of the item.
     * This method returns the HTML markup to be used for the achor label taking
     * into account the icon(s) to be displayed for this item.
     * @param array $item specifies an item in the main menu, drop menu or fly menu.
     * @param string $iconClass specfies the default iconClass to be used for this item.
     */
    public function getItemLabel($item, $iconClass ){
        $label = array_key_exists('label', $item) ? $item['label'] : "Invalid";
        
        // Add icon if one is specified
        if ( array_key_exists('iconClass', $item) ){
            $class = $item['iconClass'];
            $label = "<span class='$class'></span><span>$label</span>";
        }
        
        // Add icon for drop/fly menu
        $items = array_key_exists('items', $item) ? $item['items'] : array();
        if ($iconClass && count($items) > 0 ){
            $label = "<span>$label</span><span class='$iconClass'></span>";
        }
        return $label;
    }
    
    /* ========================= utility methods ============================*/
    /**
     * Merges options from the first $item into $options.
     * @param array $options specifies the options to the overridden.
     * @param array $item contains the options which are overridden.
     * @return array effective options for the item.
     */
    public function mergeOptions($options, $item){
        $itemOptions = array_key_exists('options', $item)? $item['options'] : array();
        return array_merge($options, $itemOptions);
    }
    
    /**
     * Removes any invisible items for the list of items.
     * @param array $items the list to be processed.
     * @return array in which invisible itens are removed. 
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
