<?php

/**
 * Jupiter dropdown menu.
 * 
 * JupiterDropdownMenu allows you to create a mutli-level dropdown menu where the
 * background gradients of the menu, the dropdown menu and the fly menu can be 
 * set individually. It also allows you to set the hover gradients of the items 
 * individually. Typically, you do not have to set the gradient values for the
 * menu since they are set from the currently active skin. If however, you want
 * to look it different then what is defined by the active skin, you need to set
 * one or more these gradients. In the following example the menu gradient is set to 
 * glassyRosyBrown7.
 * 
 * See this example {@link http://www.yiigems.com/index.php/site/page?view=demo.siteMenus.jupiterDropdownMenu Here}
 * <pre>
 * 
 * $this->widget("ext.yiigems.widgets.dropdown.JupiterDropdownMenu", array(
 *   'dropMenuIconClass'=>'icon-chevron-down pull-right',
 *   'flyMenuIconClass'=>'icon-chevron-right pull-right',
 *   'menuGradient'=>'glassyRosyBrown7',
 *   'items' => $items,
 * ));
 * 
 * The item array was defined as follows:
 * 
 * $items = array(
 *       array( 'label'=>"Home", 'url'=>array("/site/index"), 'iconClass'=>'icon-home pull-left' ),
 *       array( 'label'=>"Italian Cars", 'items'=>array(
 *           array( 'label'=>"Lamborghini", 'url'=>"javascript:void(0)", 'iconClass'=>'icon-arrow-right pull-left' ),
 *           array( 'label'=>"Ferrari", 'url'=>"javascript:void(0)" , 'iconClass'=>'icon-arrow-right pull-left'),
 *           array( 'label'=>"Maserati", 'url'=>"javascript:void(0)", 'iconClass'=>'icon-arrow-right pull-left' ),
 *           array( 'label'=>"Fornasari", 'url'=>"javascript:void(0)", 'iconClass'=>'icon-arrow-right pull-left' ),
 *           array( 'label'=>"Covini", 'url'=>"javascript:void(0)", 'iconClass'=>'icon-arrow-right pull-left' ),
 *      )),
 *       array( 'label'=>"German Cars", 'items'=>array(
 *           array( 'label'=>"Mercedes", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"BMW", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Audi", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Porsche", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Volkswagon", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Others", 'iconClass'=>'icon-car pull-left', 'items'=>array(
 *                  array( 'label'=>"Jetcar", 'url'=>"javascript:void(0)" ),
 *                  array( 'label'=>"Alpina", 'url'=>"javascript:void(0)" ),
 *                  array( 'label'=>"Gumpert", 'url'=>"javascript:void(0)" ),
 *                  array( 'label'=>"Isdera", 'url'=>"javascript:void(0)" ),
 *                  array( 'label'=>"Lotec", 'url'=>"javascript:void(0)" ),
 *                  array( 'label'=>"Melcus", 'url'=>"javascript:void(0)" ),
 *              ) 
 *           ),
 *       )),
 *       array( 'label'=>"Swedish Cars", 'items'=>array(
 *           array( 'label'=>"Saab", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Volvo", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Koenigsegg", 'url'=>"javascript:void(0)" ),
 *           array( 'label'=>"Caresto", 'url'=>"javascript:void(0)" ),
 *       )),
 *   );
 * 
 * </pre> 
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.dropdown
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.DropDownWidget");
Yii::import("ext.yiigems.widgets.dropdown.JupiterDropdownMenuDefaults");
Yii::import("ext.yiigems.widgets.common.utils.RoundStyleUtil");

class JupiterDropdownMenu extends DropDownWidget {
    /**
     * @var string The background gradient of the menu bar. 
     */
    public $menuGradient;
    
    /**
     * @var string The background gradient of the drop menu.
     * If not specified this value defaults to $menuGradient. 
     */
    public $dropMenuGradient;
    
    /**
     * @var string The background gradient of the fly menu.
     * If not specified this value defaults to $dropMenuGradient. 
     */
    public $flyMenuGradient;
    
    /**
     * @var string The hover gradient for the menu items.
     * If not specified defaults to a value assigned by the extension.
     */
    public $menuItemHoverGradient;
    
    /**
     * @var string the hover gradient for the drop menu items. 
     * If not specified this value defaults to $menuItemHoverGradient.
     */
    public $dropMenuItemHoverGradient;
    
    /**
     * @var string the hver gradient for the fly menu items.
     * If not specified this value defaults to $dropMenuItemHoverGradient.
     */
    public $flyMenuItemHoverGradient;
    
    /**
     * @var boolean specifies whether shadow should be displayed for the menu.
     */
    public $displayShadow = true;
    
    /**
     * @var string Specifies the direction of the shadow.
     * Defaults to the string "bottom_right" for DefaultSkin. 
     */
    public $shadowDirection;
    
    /**
     * @var boolean specifies whether shadow should have color.
     * If false a gray shadow will be displayed otherwise colored shadow is shown.
     */
    public $coloredShadow;
    
    /**
     * @var string the round style for the menu.
     * The default value is "big_round". 
     */
    public $menuRoundStyle;
    
    /**
     * @var string specifies the round style of the main menu items.
     * The round style is visible only when the menu item is hovered. 
     */
    public $menuItemRoundStyle;
    
    /**
     * @var string specifies the round style of the drop menu.
     * The default value is "big_round". 
     */
    public $dropMenuRoundStyle;
    
    /**
     * @var string specifies the round style of the fly menu.
     * The default value is "big_round". 
     */
    public $flyMenuRoundStyle;
    
    /**
     * @var string specifies the font size of the menu items to be used. 
     */
    public $fontSize;
    
    /**
     * @var array The HTML options for the menu container element. 
     */
    public $menuOptions = array();
    
    /**
     * @var array HTML options to be passed to the drop menu element. 
     */
    public $dropMenuOptions = array();
    
    /**
     * @var array The HTML options to be passed to the fly menu element. 
     */
    public $flyMenuOptions = array();
    
    /**
     * @var array HTML options for the menu item on the main menu. 
     */
    public $menuItemOptions = array();
    
    /**
     * @var array  HTML options for the menu item in the drop menu.
     */
    public $dropMenuItemOptions = array();
    
    /**
     * @var array HTML options for the menu item in the fly menu. 
     */
    public $flyMenuItemOptions = array();
    
    /**
     * @var array HTML options for the anchor on the main menu. 
     */
    public $menuAnchorOptions = array();
    
    /**
     * @var array HTML options for the anchor on the drop menu. 
     */
    public $dropMenuAnchorOptions = array();
    
    /**
     * @var array HTML options for the anchor on the fly menu. 
     */
    public $flyMenuAnchorOptions = array();
    
    /**
     * @var array The list of items in the menu.
     * A menu item without any child item has the following form:
     * <pre>
     * 
     * array( 
     *    'label'=>"Home", 
     *    'url'=>array("/site/index"), 
     *    'iconClass'=>'icon-home pull-left', 
     *    'options'=>array( 'style'=>'color:red'),
     * )
     * 
     * </pre>
     * 
     * A menu item with any child has a key named items which contains the definition
     * of the child items:
     * <pre>
     * 
     * array( 
     *    'label'=>"Manage Jobs", 
     *    'iconClass'=>'icon-comment pull-left',
     *    'options'=>array( 'style'=>'color:red'), 
     *    'items'=>array(
     *        array( 'label'=>"Option1", 'url'=>"javascript:void(0)" ),
     *        array( 'label'=>"Option2", 'url'=>"javascript:void(0)" ),
     *        array( 'label'=>"Option3", 'url'=>"javascript:void(0)" ),
     *        array( 'label'=>"Option4", 'url'=>"javascript:void(0)" ),
     *     )  
     * )
     * 
     * </pre>
     */
    public $items = array();
    
    /**
     * @var string Specifies the icon to indicate presence of a dropdown menu.  
     */
    public $dropMenuIconClass = "icon-chevron-sign-down pull-right";
    
    /**
     * @var string Specifies the icon to indicate presence of a fly menu. 
     */
    public $flyMenuIconClass = "icon-chevron-sign-right pull-right";
    
    /**
     * @var string the name of the skin class associated with this widget.
     */
    public $skinClass = "JupiterDropdownMenuDefaults";
    
//    private static $firstItemRoundInfo = array(
//         'no_round'=> "no_round",
//         'not_round'=> "not_round",
//         "round" => "round_top",
//         "medium_round" => "medium_round_top",
//         "big_round" => "big_round_top",
//         "round_2em" => "round_2em_top",
//    );
    
//    private static $lastItemRoundInfo = array(
//         'no_round'=> "no_round",
//         'not_round'=> "not_round",
//         "round" => "round_bottom",
//         "medium_round" => "medium_round_bottom",
//         "big_round" => "big_round_bottom",
//         "round_2em" => "round_2em_bottom",
//    );
    
    /**
     * Sets up asset information for this widget.
     * @see AppWidget::setupAssetsInfo
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "jupiter.css", dirname(__FILE__) . "/jupiter" );
        $this->addGradientAssets(array(
            $this->menuGradient,
            $this->dropMenuGradient,
            $this->flyMenuGradient,
            $this->menuItemHoverGradient,
            $this->dropMenuItemHoverGradient,
            $this->flyMenuItemHoverGradient
        ));
    }
    
    /**
     * Returns the names of the properties to be set from skin class.
     * @see AppWidget::getCopiedFields
     */
    protected function getCopiedFields(){
        return array(
            "menuTag", "itemTag",
            "menuGradient", "dropMenuGradient", "flyMenuGradient",
            "menuItemHoverGradient", "dropMenuItemHoverGradient", "flyMenuItemHoverGradient",
            "displayShadow", "shadowDirection", "coloredShadow",
            "menuRoundStyle", "menuItemRoundStyle", "dropMenuRoundStyle",
            "menuRoundStyle", "menuItemRoundStyle",
            "dropMenuRoundStyle",
            "flyMenuRoundStyle",
            "fontSize"
        );
    }
    
    /**
     * Returns the names of the properties to be merged from skin class.
     * @see AppWidget::getMergedFields
     */
    protected function getMergedFields(){
        return array(
            "menuOptions", "dropMenuOptions", "flyMenuOptions", 
            "menuItemOptions", "dropMenuItemOptions", "flyMenuItemOptions", 
            "menuAnchorOptions", "dropMenuAnchorOptions", "flyMenuAnchorOptions",
        );
    }
    
    /**
     * Sets the values of widget properties to default values.
     * @see AppWidget::setMemberDefaults
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();

        $this->id = $this->id ? $this->id : UniqId::get("btn-");
                
        // set other missing members according to rules specific to this widget
        if ( !$this->dropMenuGradient ) $this->dropMenuGradient = $this->menuGradient;
        if ( !$this->flyMenuGradient ) $this->flyMenuGradient = $this->dropMenuGradient;
        
        if ( !$this->menuItemHoverGradient ) $this->menuItemHoverGradient = GradientUtil::getHoverGradient ($this->menuGradient);
        if ( !$this->dropMenuItemHoverGradient ) $this->dropMenuItemHoverGradient = $this->menuItemHoverGradient;
        if ( !$this->flyMenuItemHoverGradient ) $this->flyMenuItemHoverGradient = $this->dropMenuItemHoverGradient;
        
        if ( !$this->dropMenuRoundStyle ) $this->dropMenuRoundStyle = $this->menuRoundStyle;
        if ( !$this->flyMenuRoundStyle ) $this->flyMenuRoundStyle = $this->dropMenuRoundStyle;
    }
    
    /**
     * Initializes this widget.
     * @see CWidget::init
     */
    public function init() {
         parent::init();
        $this->registerAssets();
        $this->createMenu();
    }
    
    //=========================== Menu options =================================
    
    /**
     * @return array return HTML options for the menu container.
     */
    public function getMenuOptions(){
        $cssClass = "jupiter  background_$this->menuGradient color_$this->menuGradient";
        if ($this->menuRoundStyle ) $cssClass .= " $this->menuRoundStyle";
        if ($this->fontSize ) $cssClass .= " $this->fontSize";
        if ($this->displayShadow ) {
            if ( $this->coloredShadow ) {
                $cssClass .= " shadow_{$this->shadowDirection}_{$this->menuGradient}";
            }
            else {
                $cssClass .= " shadow_$this->shadowDirection";
            }
        }
        $options = $this->menuOptions;
        $options['class'] = $cssClass;
        return $options;
    }
    
    /**
     * Returns the html options to be used for the specified drop menu item. 
     * @param array $menu specifies the drop menu item.
     * @return array HTML options for the drop menu item. 
     */
    public function getDropMenuOptions($menu){
        $cssClass = "";
        if ( $this->dropMenuGradient ) $cssClass .= " background_$this->dropMenuGradient";
        if ( $this->dropMenuGradient ) $cssClass .= " color_$this->dropMenuGradient";
        if ( $this->dropMenuGradient ) $cssClass .= " border_$this->dropMenuGradient";
        
        if ($this->dropMenuRoundStyle ) $cssClass .= " $this->dropMenuRoundStyle";
        
        if ($this->displayShadow ) {
            if ( $this->coloredShadow ) {
                $cssClass .= " shadow_{$this->shadowDirection}_{$this->dropMenuGradient}";
            }
            else {
                $cssClass .= " shadow_$this->shadowDirection";
            }
        }
        $options = $this->mergeOptions($this->dropMenuOptions, $menu);
        $options['class'] = $cssClass;
        return $options;
    }
    
    /**
     * Returns the html options to be used for the specified fly menu item. 
     * @param array $menu specifies the fly menu item.
     * @return array HTML options for the fly menu item. 
     */
    public function getFlyMenuOptions($menu){
       $cssClass = "";
       if ( $this->flyMenuGradient ) $cssClass .= " background_$this->flyMenuGradient";
        if ( $this->flyMenuGradient ) $cssClass .= " color_$this->flyMenuGradient";
        if ( $this->flyMenuGradient ) $cssClass .= " border_$this->flyMenuGradient";
        if ($this->flyMenuRoundStyle ) $cssClass .= " $this->flyMenuRoundStyle";
        if ($this->displayShadow ) {
            if ( $this->coloredShadow ) {
                $cssClass .= " shadow_{$this->shadowDirection}_{$this->flyMenuGradient}";
            }
            else {
                $cssClass .= " shadow_$this->shadowDirection";
            }
        }
        $options = $this->mergeOptions($this->flyMenuOptions, $menu);
        $options['class'] = $cssClass;
        return $options;
    }
    
    //========================== Item options ================================
    
    /**
     * Returns the HTML options for the menu item on the main menu.
     * @param array $item specifies a menu item
     * @return array HTML options for the menu item. 
     */
    public function getMenuItemOptions($item){
        return $this->mergeOptions($this->menuItemOptions, $item);
    }
    
    /**
     * Returns the HTML options for the menu item on a drop menu.
     * @param array $item specifies a drop menu item
     * @return array HTML options for the drop menu item. 
     */
    public function getDropMenuItemOptions($item){
        return $this->mergeOptions($this->dropMenuItemOptions, $item);
    }
    
    public function getDropMenuSeparatorOptions($item){
        // Get item options
        $itemOptions = $this->mergeOptions(array(), $item);
        
        // Set the class for sep[arator
        $class = "separator border_$this->dropMenuGradient";
        $options = array( 'class' => $class );
        return ComponentUtil::mergeHtmlOptions($options, $itemOptions );
    }
    
    /**
     * Returns the HTML options for the menu item on a fly menu.
     * @param array $item specifies a drop fly item
     * @return array HTML options for the fly menu item. 
     */
    public function getFlyMenuItemOptions($item){
        return $this->mergeOptions($this->flyMenuItemOptions, $item);
    }
    
    public function getFlyMenuSeparatorOptions($item){
        // Get item options
        $itemOptions = $this->mergeOptions(array(), $item);
        
        // Set the class for sep[arator
        $class = "separator border_$this->flyMenuGradient";
        $options = array( 'class' => $class );
        return ComponentUtil::mergeHtmlOptions($options, $itemOptions );
    }
    
    //========================== Anchor options ================================
    
    /**
     * Returns the HTML options for the anchor on the main menu.
     * @param array $item specifies a item on the main menu.
     * @return array HTML options for the menu item. 
     */
    public function getMenuAnchorOptions( $item, $index, $count ){
        $itemOptions = $this->mergeOptions($this->menuAnchorOptions, $item);
        
        $cssClass = "hover_background_$this->menuItemHoverGradient";
        $cssClass .= " color_$this->menuGradient";
        $cssClass .= " hover_color_$this->menuItemHoverGradient";
        if($this->menuItemRoundStyle) $cssClass .= " $this->menuItemRoundStyle";
        $itemOptions['class'] = $cssClass;
        return $itemOptions;
    }
    
    /**
     * Returns the HTML options for the anchor on a drop menu.
     * @param array $item specifies a item on a drop menu.
     * @return array HTML options for the menu item. 
     */
    public function getDropMenuAnchorOptions( $item, $index, $count ){
        $itemOptions = $this->mergeOptions($this->dropMenuAnchorOptions, $item);
        
        $cssClass = "hover_background_$this->dropMenuItemHoverGradient";
        $cssClass .= " hover_color_$this->dropMenuItemHoverGradient";
        $cssClass .= " color_$this->dropMenuGradient";
        
        if ( $index == 0) $cssClass .= " " . RoundStyleUtil::getTopRoundStyle($this->dropMenuRoundStyle);
        if ( $index + 1 == $count) $cssClass .= " " . RoundStyleUtil::getBottomRoundStyle($this->dropMenuRoundStyle);
        $itemOptions['class'] = $cssClass;
        return $itemOptions;
    }
    
    /**
     * Returns the HTML options for the anchor on a fly menu.
     * @param array $item specifies a item on a fly menu.
     * @return array HTML options for the menu item. 
     */
    public function getFlyMenuAnchorOptions( $item, $index, $count ){
        $itemOptions = $this->mergeOptions($this->flyMenuAnchorOptions, $item);
        
        $cssClass = "hover_background_$this->flyMenuItemHoverGradient";
        $cssClass .= " hover_color_$this->flyMenuItemHoverGradient";
        $cssClass .= " color_$this->flyMenuGradient";

        if ( $index == 0) $cssClass .= " " . RoundStyleUtil::getTopRoundStyle($this->flyMenuRoundStyle);
        if ( $index + 1 == $count) $cssClass .= " " . RoundStyleUtil::getBottomRoundStyle($this->flyMenuRoundStyle);
        $itemOptions['class'] = $cssClass;
        return $itemOptions;
    }
    
    public function computeSearchBoxOptions($item){
        $textBoxOptions = array_key_exists("textBoxOptions", $item) ? $item['textBoxOptions'] : array();
        return ComponentUtil::mergeHtmlOptions(JupiterDropdownMenuDefaults::$searchTextOptions, $textBoxOptions);
    }
}

?>
