<?php

/**
 * An widget to display colored labels and badges.
 * The colored label widget is used to display a label with a colored background.
 * It can set a plain HTML color or a gradient background defined by Yii extension.
 * 
 * <pre>
 * The DefaultSkin class defines the following scenarios for ColoredLabel:
 * info - used to display information text.
 * warning - used to display warning text.
 * error - used to indicate error.
 * error - used to indicate error.
 * success - used to indicate success.
 * failure - used to indicate failure.
 * alert - used to display an alert text.
 * </pre>
 * 
 * Here is an example to create an ColoredLabel in a view:
 * 
 * <pre>
 * $this->widget("ext.yiigems.widgets.labels.ColoredLabel", array(
 *    'labelText'=> 'Hello',
 *    'scenario'=>'info'
 * ));
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.labels
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import( "ext.yiigems.widgets.common.AppWidget");
Yii::import( "ext.yiigems.widgets.common.utils.StyleUtil");
Yii::import( "ext.yiigems.widgets.labels.ColoredLabelDefaults");

class ColoredLabel_1 extends AppWidget {
    /**
     * @var string the text to be displayed on the label. 
     */
    public $labelText;
    
    /**
     * @var string the gradient to be used as background of the label. 
     * This property is ignored if $backgroundColor is set.
     */
    public $gradient;
    
    /**
     * @var string the background color of the label.
     * This property takes precedance over $gradient property. 
     */
    public $backgroundColor;
    
    /**
     * @var string the color of the text.
     */
    public $textColor;
    
    /**
     * @var string the icon to be displayed on the label.
     */
    public $iconClass;
    
    /**
     * @var string the size of the font to be used by thuis label. 
     */
    public $fontSize;
    
    /**
     * @var string the style of the rounded corners for this label. 
     */
    public $roundStyle;
    
    /**
     * @var boolean whether a shadow should be displayed for the label.  
     */
    public $displayShadow;
    
    /**
     * @var boolean whether the shadow should be colored or gray. 
     */
    public $coloredShadow;
    
    /**
     * @var string te direction shadow color. 
     */
    public $shadowDirection;
    
    /**
     * @var string the icon to be displayed on the label.
     */
    //public $addCssClass;
    
    /**
     * @var array the HTML options for the label element. 
     */
    public $options;
    
    /**
     * @var string the name of the skin class for this widget. 
     */
    public $skinClass = "ColoredLabelDefaults";
    
    /**
     * Sets up asset information for the label. 
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            "clabel.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->gradient);
    }
    
    /**
     * @return array the list of properties to be set from skin class. 
     */
    protected function getCopiedFields(){
        return array(
            "gradient", "backgroundColor", "textColor",
            "iconClass", "fontSize", "roundStyle",
            "displayShadow", "coloredShadow", "shadowDirection",
        );
    }
    
    /**
     * @return array the list of properties to be merged from the akin class. 
     */
    protected function getMergedFields(){
        return array( "options" );
    }
    
    /**
     * Initializes this widget by generaing all markups. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "span", $this->getLabelOptions());
        echo $this->getLabelText();
        echo CHtml::closeTag( "span" );
    }
    
    /**
     * @return array the HTML options for this label. 
     */
    private function getLabelOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => 'clabel',
            'addClass' => $this->addClass,
            
            'bgGradient' => $this->gradient,
            'bgColor' => $this->backgroundColor,
            'fgColor' => $this->gradient,
            
            'borderGradient' => $this->gradient,
            
            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,
            'shadowGradient' => $this->gradient,
            
            'roundStyle' => $this->roundStyle,
            'fontSize' => $this->fontSize,
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->options);
    }
    
    /**
     * @return string the label for this widget. 
     */
    private function getLabelText(){
        $label = $this->labelText;
        if ( $this->iconClass ){
            $label = "<span class='$this->iconClass' style='line-height:1.6em'></span>" . $label;
        }
        return $label;
    }
}

?>
