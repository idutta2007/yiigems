<?php

/**
 * Widget to create a horizontal bar of buttons.
 *
 * ButtonBar widgets allows you to create a list of buttons in a bar. An icon
 * can be displayed for each button by specifying the default icon for the button
 * bar or separate icons can be displayed for individual buttons. A button in a 
 * button bar can be simple link or  an action button. You can also disable 
 * rendering of a button in a ButtonBar by setting the property visible of an 
 * item to false.
 * 
 * <pre>
 * 
 * $this->widget('ext.yiigems.widgets.buttonGroup.ButtonBar', array(
 *    'gradient'=>'glassyGray6',
 *    'items'=>array(
 *       array( 'label'=>'Home', 'url'=>array("site/index" ) ),
 *       array( 'label'=>'About Us', 'url'=>array("site/about" ) ),
 *       array( 'label'=>'FAQ', 'url'=>array("site/faq" ) ),
 *       array( 'label'=>'Register', 'itemType'=>'action', 'script'=>"alert('Hello there!')" ),
 *       array( 'label'=>'Contact', 'url'=>array("site/contact" ) ),
 *    )
 *));
 * 
 * </pre>
 * <pre>
 * Each item in the items array  can have the following properties:
 * itemType - specifies whether it is a link or an action button. Possible
 *            values are "link" or "action". If not specified "link" is assumed.
 * label - specifies the label to be displayed.
 * url - specifies the URL if it is a link.
 * script - the javascript code to be executed if it is an action button.
 * selected - specifies whether the button is in selected state.
 * visible - specifies whether the button is visible.
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttonGroup
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */


Yii::import("ext.yiigems.widgets.common.utils.GradientUtil");
Yii::import("ext.yiigems.widgets.buttonGroup.ButtonGroup");
Yii::import("ext.yiigems.widgets.buttonGroup.ButtonBarDefaults");
Yii::import("ext.yiigems.widgets.common.behave.LinkContainerBehavior");

class ButtonBar extends ButtonGroup {
    /**
     * @var string The gradient which is used as a basis for separator color.
     * Use this only when you want the separator color to be different from default
     * If you specify a gradient here, the border color associated with the gradient
     * will be used as the separator color.
     *  
     */
    public $separatorGradient;
    
    /**
     * @var string The color of the separator between buttons.
     * If this property is specified, then $separatorGradient is ignored. 
     * 
     */
    public $separatorColor;
    
    /**
     * @var string The skin class for this widget.
     * Override this only if you want to specify a different skin class for this
     * widget. Defaults to "ButtonBarDefaults" class.
     *  
     */
    protected $skinClass = "ButtonBarDefaults";
    
    private static $firstItemRoundInfo = array(
         'no_round'=> "no_round",
         'not_round'=> "not_round",
         "round" => "round_left",
         "medium_round" => "medium_round_left",
         "big_round" => "big_round_left",
         "round_2em" => "round_2em_left",
    );
    
    /**
     * Sets up assets information of this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "buttonBar.css", dirname(__FILE__) . "/assets" );
        $this->addGradientAssets(array(
            $this->gradient, $this->hoverGradient,
            $this->activeGradient,  $this->selectedGradient,
            $this->separatorGradient, $this->selectedColor
        ));
    }
    
    /**
     * @return array the list of properties copied from skin class.
     */
    protected function getCopiedFields(){
        return array_merge(
                parent::getCopiedFields(),
                array("separatorGradient", "separatorColor")
        );
    }
    
    /**
     * Initializes the button bar.
     * Register all assets after copying property values from the skin class and
     * produces all markups except the end tags for the list and nav element. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        $this->attachBehavior("linkCont", new LinkContainerBehavior());
        
        echo CHtml::openTag( $this->containerTag, $this->getContainerOptions());
        echo CHtml::openTag($this->listTag, $this->getListOptions());
        
        // Remove invisible items
        $items = $this->removeInvisibleItems($this->items);
        
        // Render the items
        $count = count($items);
        foreach ($items as $index=>$item ) {
            echo CHtml::openTag($this->itemTag, $this->getItemOptions($item, $index, $count));
            $item['labelMarkup'] = $this->getLabel($item);
            $item['anchorOptions'] = $this->getAnchorOptions($item, $index, $count);
            $this->renderItem($item);
            echo CHtml::closeTag($this->itemTag);
        }
    }
    
    /**
     * Returns the list of HTML options to be used for the nav element.
     * @return array 
     */
    private function getContainerOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => "buttonBar",
            'addClass' => $this->addClass,
            'bgGradient' => $this->gradient,
            'roundStyle' => $this->roundStyle,
            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,
            'shadowGradient' => $this->gradient,
            'fontSize' => $this->fontSize,
        ));
        return ComponentUtil::mergeHtmlOptions( $options, $this->containerOptions );
    }

    /**
     * Returns the HTML options to be used for the list element.
     * @return array 
     */
    private function getListOptions(){
        return $this->listOptions;
    }
    
    /**
     * Returns the HTML options to be used a list element.
     * @param array $item specifies the button.
     * @param integer $index is position of the button in the button bar.
     * @param integer $count total number of buttons rendered.
     * @return array the options for the list item. 
     */
    protected function getItemOptions($item, $index, $count){
        $cssClass = "";
        $style = array();
        if ($this->separatorColor){
            $style['border-right-color'] = $this->separatorColor;
        }
        else if ($this->separatorGradient){
            $cssClass = "border_$this->separatorGradient";
        }
        if ( $index == 0) $cssClass .= " " . self::$firstItemRoundInfo[$this->roundStyle];
        
        $options = array();
        $options['class'] = $cssClass;
        $options['style'] = StyleUtil::createStyle($style);

        return ComponentUtil::mergeHtmlOptions($options, $this->itemOptions);
    }
    
    /**
     * Returns the HTML options to be used an anchor element.
     * @param string $item specifies the button.
     * @param string $index is position of the button in the button bar.
     * @param string $count total number of buttons rendered.
     * @return array the options for the anchor element. 
     */
    protected function getAnchorOptions($item, $index, $count){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $item['id'],
            'addClass' => array_key_exists( "addClass", $item ) ? $item['addClass'] : "",
            'selected' => array_key_exists( "selected", $item ) ? $item['selected'] :false,

            'bgGradient' => $this->gradient,
            'hoverBgGradient' => $this->hoverGradient,
            'activeBgGradient' => $this->activeGradient,
            'selectedBgGradient' => $this->selectedGradient,

            'fgColor' => $this->gradient,
            'hoverFgColor' => $this->hoverGradient,
            'activeFgColor' => $this->activeGradient,
            'selectedFgColor' => $this->selectedGradient,
            'selectedBgColor' => $this->selectedColor,

            'fontSize' => $this->fontSize,
            'roundStyle' => ($index == 0) ? self::$firstItemRoundInfo[$this->roundStyle] : false,
        ));

        $itemOptions = array_key_exists( "options", $item ) ? $item["options"] : array();
        return ComponentUtil::mergeHtmlOptions( $options, $itemOptions );
    }

    /**
     * Produces the end tags for the button bar. 
     */
    public function run(){
        echo CHtml::closeTag($this->listTag);
        echo CHtml::closeTag($this->containerTag);
    }
}

?>
