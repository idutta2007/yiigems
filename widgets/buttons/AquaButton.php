<?php

/**
 * Widget to create Mac style Aqua buttons. 
 * AquaButton widget allows you to create an "aqua" styled button using CSS 
 * shadow. YiiGems provides 8 different shadows varying in brightness for each
 * named HTML color. For example, for the HTML color named aliceBlue, the extension
 * provides 8 shadows named aquaAliceBlue1, aquaAliceBlue2 ... aquaAliceBlue8.
 * While creating an AquaButton set the shadow name to an appropriate name to
 * get the desired aqua button. 
 * 
 * As an example, here is how you will create an aqua button with shadow named
 * aquaAliceBlue1:
 * <pre>
 * 
 * $this->widget("ext.yiigems.widgets.buttons.AquaButton", array(
 *    'shadowName' => 'aquaAliceBlue1',
 *    'label' => 'Hello',
 *    'url' => "javascript:void(0)"
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
Yii::import("ext.yiigems.widgets.buttons.AquaButtonDefaults");
Yii::import("ext.yiigems.widgets.utils.ComponentUtil");

class AquaButton extends ButtonWidget {
    /**
     * @var string The HTML tag used by this widget.
     */
    public $htmlTag;
    
    /**
     * @var string the name of shadow which detrmines how it will look like.
     */
    public $shadowName;
    
    /**
     * @var string round style of the button. 
     */
    public $roundStyle;
    
    /**
     * @var string the font size used or the button.
     */
    public $fontSize;
    
    /**
     * @var string whether it is a link button, action button or submit button.
     */
    public $buttonType = "link";
    
    /**
     * @var array the HTML options passed to the aqua button tag. 
     */
    public $htmlOptions = array();

    public $skinClass = "AquaButtonDefaults";


    /**
     *Sets up assets information of this widget. 
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->assetsInfo[] = array(
            'name' => "button.css",
            'assetDir' => dirname(__FILE__) . "/assets/common"
        );
        if ($this->shadowName) {
            $this->addAssetInfo(
                    GradientUtil::getCssFileForAquaShadow($this->shadowName),   
                    GradientUtil::getAquaShadowAssetDir($this->shadowName)
            );
        }
    }

    function getCopiedFields(){
        return array( "htmlTag", "roundStyle", "fontSize" );
    }

    function getMergedFields(){
        return array( "htmlOptions");
    }
    
    /**
     * Method to set the widget property values to default after creation. 
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("abtn-");
    }
    
    /**
     * Initializes the aqua button.
     * Register all assets after copying property values from the skin class and
     * produces all markups for the button. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        $options = $this->getButtonOptions();

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
     * @return array the HTML options for this button. 
     */
    private function getButtonOptions(){
        $cssClass = "button aquaBtn border_{$this->shadowName} hover_border_{$this->shadowName}h active_border_{$this->shadowName}a";
        $cssClass .= " {$this->shadowName} hover_{$this->shadowName}h active_{$this->shadowName}a";
        $cssClass .= " color_{$this->shadowName} hover_color_{$this->shadowName}h active_color_{$this->shadowName}a";
        if ( $this->fontSize ) $cssClass .= " $this->fontSize";
        if ( $this->roundStyle ) $cssClass .= " $this->roundStyle";

        $options = array();
        $options['class'] = $cssClass;

        return ComponentUtil::mergeHtmlOptions($options, $this->htmlOptions);
    }
    
    /**
     * Generates the closing tag for the button. 
     */
    public function run(){
        if ($this->htmlTag != "a") {
            echo CHtml::closeTag($this->htmlTag);
        }
    }
}
?>
