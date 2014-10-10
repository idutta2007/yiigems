<?php
/**
 * Widget to create a vertical stack of buttons.
 *
 * ButtonStack widgets allows you to create a list of buttons in a vertical stack. 
 * An icon can be displayed for each button by specifying the default icon for 
 * the button bar or separate icons can be displayed for individual buttons. A 
 * button in a button bar can be simple link or an action button.
 * You can also disable rendering of a button in a ButtonStack by setting the
 * property 'visible' of an item to false. The following example shows how to create
 * a button stack with an action item.
 * 
 * <pre>
 * 
 * $this->widget('ext.yiigems.widgets.buttonGroup.ButtonStack', array(
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
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttonGroup
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");
Yii::import("ext.yiigems.widgets.common.utils.GradientUtil");
Yii::import("ext.yiigems.widgets.buttonGroup.ButtonGroup");
Yii::import("ext.yiigems.widgets.buttonGroup.ButtonStackDefaults");
Yii::import("ext.yiigems.widgets.common.behave.LinkContainerBehavior");

class ButtonStack extends ButtonGroup {
    /**
     * @var string The skin class associated with this widget. 
     */
    protected $skinClass = "ButtonStackDefaults";
    
    /**
     * Sets up assets information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            "buttonStack.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets(array(
            $this->gradient, $this->hoverGradient,
            $this->activeGradient, $this->selectedGradient
        ));
    }
    
    /**
     * Initializes this widget by publishing and registering assets.
     * This method also generates the markup for the buttons in the ButtonStack. 
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
    
    private function getContainerOptions(){
        $options = array();
        $options['class'] = "vertButtonBar";
        $options['id'] = $this->id;

        return ComponentUtil::mergeHtmlOptions( $options, $this->containerOptions);
    }
    
    private function getListOptions(){
        return $this->listOptions;
    }
    
    /**
     * Returns the HTML options to be used for a list element.
     * @param array $item specifies the button.
     * @param integer $index is position of the button in the button bar.
     * @param integer $count total number of buttons rendered.
     * @return array the options for the list item. 
     */
    protected function getItemOptions($item, $index, $count){
       return $this->itemOptions;
    }
    
    /**
     * Returns the HTML options to be used for an anchor element.
     * @param array $item specifies the button.
     * @param integer $index is position of the button in the button bar.
     * @param integer $count total number of buttons rendered.
     * @return array the options for the list item. 
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

            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,

            'roundStyle' => $this->roundStyle,
            'fontSize' => $this->fontSize,
        ));

        $itemOptions = array_key_exists( "options", $item ) ? $item["options"] : array();
        return ComponentUtil::mergeHtmlOptions( $options, $itemOptions);
    }

    public function run(){
        echo CHtml::closeTag($this->listTag);
        echo CHtml::closeTag( $this->containerTag);
    }
}

?>
