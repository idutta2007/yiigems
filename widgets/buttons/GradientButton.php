<?php

/**
 * Widget to create a button with gradient background.
 * YiiGems extension defines hundreds of CSS gradients any of which can be set
 * as background, hover background or active background of a GradientButton. This
 * is done by setting the properties gradient, hoverGradient and activeGradient
 * of the GradientButton. If you set only the gradient, the extension automatically
 * assigns matching gradients for hover or active state.
 * 
 *   When you set one or more gradient properties of a GradientButton, the 
 * corresponding stylesheets are automatically included in the page. You do not
 * have to do anything extra to include them.
 * 
 * The following is an example of a gradient button with the gradient named 
 * glassyOliveDrab6. For more information about YIIGems gradients see this
 * {@link http://www.yiigems.com/index.php/site/page?view=demo.yiigems.gradients page}.
 * <pre>
 * 
 * $this->widget("ext.yiigems.widgets.buttons.GradientButton", array(
 *   'gradient' => 'glassyOliveDrab6',
 *   'label' => 'Home',
 *   'url' => "javascript:void(0)",
 * ));
 * 
 * </pre>
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttons
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */


Yii::import("ext.yiigems.widgets.common.ButtonWidget");
Yii::import("ext.yiigems.widgets.buttons.GradientButtonDefaults");
Yii::import("ext.yiigems.widgets.common.utils.GradientUtil");

class GradientButton extends ButtonWidget {
    /**
     * @var The HTML tag used for the gradient button. 
     */
    public $htmlTag = "a";
    
    /**
     * @var string the background gradient of the button. 
     */
    public $gradient;
    
    /**
     * @var string the background gradient to be used for hover state. 
     */
    public $hoverGradient;
    
    /**
     * @var string the background gradient to be used for active state.  
     */
    public $activeGradient;
    
    /**
     * @var string the background gradient to be used for selected state. 
     */
    public $selectedGradient;
    
    /**
     * @var boolean whether the button should display a shadow. 
     */
    public $displayShadow;
    
    /**
     * @var string the direction of button shadow. 
     */
    public $shadowDirection;
    
    /**
     * @var string border style of the button. 
     * Two values are supported - inset or outset.
     */
    public $borderStyle;
    
    /**
     * @var string the border style of the button in the hover state. 
     */
    public $hoverBorderStyle;
    
    /**
     * @var string the border style of the button in the active state. 
     */
    public $activeBorderStyle;

    /**
     * @var string the border style of the button in the selected state.
     */
    public $selectedBorderStyle;
    
    /**
     * @var string the round style of this button. 
     */
    public $roundStyle;
    
    /**
     * @var boolean whether the shadow displayed should be colored. 
     */
    public $coloredShadow;
    
    /**
     * @var string the size of font associated with this button.
     */
    public $fontSize;
    
    /**
     * @var string the icon associated with this button. 
     */
    public $iconClass;
    
    /**
     * @var boolean whether the button is currently selected. 
     */
    public $selected = false;
    
    /**
     * @var string the skin class associated with this button. 
     */
    public $skinClass = "GradientButtonDefaults";
    
    
    public $buttonCssFile = "button.css";
    public $buttonClass = "button";
    
    /**
     *Sets up assets information of this widget. 
     */
    public function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( $this->buttonCssFile, dirname(__FILE__) . "/assets/common" );
        $this->addGradientAssets(array(
            $this->gradient, $this->hoverGradient,
            $this->activeGradient, $this->selectedGradient
        ));
    }
    
    /**
     * @return array the list of properties copied from skin class.
     */
    protected function getCopiedFields(){
        return array(
            "htmlTag", 
            "gradient", "hoverGradient", "activeGradient", "selectedGradient",
            "borderStyle", "hoverBorderStyle", "activeBorderStyle", "selectedBorderStyle",
            "displayShadow", "shadowDirection", "coloredShadow",
            "roundStyle", "fontSize", "iconClass",
        );
    }
    
    /**
     * @return array the list of properties merged from skin class.
     */
    protected function getMergedFields(){
        return array( "options" );
    }
    
    /**
     * Sets default value for widget properties. 
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        
        $this->id = $this->id ? $this->id : UniqId::get("btn-");

        if ($this->selected ) $this->url = "javascript:void(0)";
        if (!$this->hoverGradient)  $this->hoverGradient = GradientUtil::getHoverGradient ($this->gradient);
        if (!$this->activeGradient)  $this->activeGradient = GradientUtil::getActiveGradient ($this->gradient);
        if (!$this->selectedGradient)  $this->selectedGradient = GradientUtil::getSelectedGradient ($this->gradient);
    }
    
    /**
     * Initializes the gradient button.
     * Register all assets after copying property values from the skin class and
     * produces all markups except the end tag. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        // set options for the container
        $options = $this->getButtonOptions();
        $this->id = $options['id'];
        
        // render based on the button type
        if ($this->htmlTag == "a") {
            if ($this->buttonType == "link") {
                $this->renderLink($options);
            } 
            else if ($this->buttonType == "submit") {
                $this->renderSubmitButton($options);
            } 
            else if ($this->buttonType == "action") {
                $this->renderActionButton($options);
            }
        }
        else {
            if ($this->buttonType == "link") {
                $this->renderLinkTag($options);
            } 
            else if ($this->buttonType == "submit") {
                $this->renderSubmitTag($options);
            } 
            else if ($this->buttonType == "action") {
                $this->renderActionTag($options);
            }
        }
    }
    
    /**
     * @return array the HTML options for the button tag. 
     */
    protected function getButtonOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => $this->buttonClass,
            'addClass' => $this->addClass,
            'selected' => $this->selected,

            'bgGradient' => $this->gradient,
            'hoverBgGradient' => $this->hoverGradient,
            'activeBgGradient' => $this->activeGradient,
            'selectedBgGradient' => $this->selectedGradient,

            'fgColor' => $this->gradient,
            'hoverFgColor' => $this->hoverGradient,
            'activeFgColor' => $this->activeGradient,
            'selectedFgColor' => $this->selectedGradient,

            'borderGradient' => $this->gradient,
            'hoverBorderGradient' => $this->hoverGradient,
            'activeBorderGradient' => $this->activeGradient,
            'selectedBorderGradient' => $this->selectedGradient,

            'borderStyle' => $this->borderStyle,
            'hoverBorderStyle' => $this->hoverBorderStyle,
            'activeBorderStyle' => $this->activeBorderStyle,
            'selectedBorderStyle' => $this->selectedBorderStyle,

            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,
            'shadowGradient' => $this->gradient,

            'roundStyle' => $this->roundStyle,
            'fontSize' => $this->fontSize,
        ));
        return ComponentUtil::mergeHtmlOptions( $options, $this->options );
    }

    /**
     * @return string the label for the button including any icon set. 
     */
    public function getLabel(){
        if ( $this->iconClass ){
            $icon = CHtml::openTag("span", array(
                'class' => "$this->iconClass"
            ));
            $icon .= CHtml::closeTag("span");
            return  $icon . " " . $this->label;
        }
        return $this->label;
    }
    
    /**
     * Produces the end tag of the button. 
     */
    public function run(){
        if ($this->htmlTag != "a") {
            echo CHtml::closeTag($this->htmlTag);
        }
    }
}

?>
