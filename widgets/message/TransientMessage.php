<?php

/**
 * Description of TransientMessage
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.message
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.message.TransientMessageDefaults");

class TransientMessage extends AppWidget {
    /**
     * @var string the icon to be displayed in front of the text. 
     */
    public $iconClass;
    
    /**
     * @var string the message content.
     * There are two ways the content of message widget can be provided. One 
     * way is to set the content attribute and the second way is to include the
     * content between beginWidget and endWidget call.
     */
    public $message;
    
    /**
     * @var string the background gradient of the message. 
     */
    public $gradient;
    
    /**
     * @var string the corner round style of the message widget. 
     */
    public $roundStyle;
    
    /**
     * @var boolean whether a shadow should be displayed for the message widget. 
     */
    public $displayShadow;
    
    public $coloredShadow;
    
    /**
     * @var string the direction of shadow for the message widget. 
     */
    public $shadowDirection;
    
    /** The fade in duration in milliseconds for the transient message */
    public $fadeInDuration = 300;
    
    /** The duration in milliseconds how long the message will stay on the screen */
    public $stayDuration = 500;
    
    /** The fade in duration in milliseconds for the transient message */
    public $fadeOutDuration = 300;
    
    /**
     * @var array the HTML options for the container tag. 
     */
    public $options = array();
    
    
    /** The jquery selector on which the message is centered */
    public $containerSelector;
    
    /**
     * @var string the name of the skin class associated with this widget. 
     */
    public $skinClass = "TransientMessageDefaults";
    
    /**
     * Sets up asset information for this widget.
     * @see AppWidget::setupAssetsInfo
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();
        
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "transientMessage.css", dirname(__FILE__) . "/assets" );
        $this->addAssetInfo( "transientMessage.js", dirname(__FILE__) . "/assets" );
        $this->addGradientAssets($this->gradient);
    }
    
    /**
     * @return array of widget prioprty names which are copied from skin class.
     */
    public function getCopiedFields(){
        return array( 
             "iconClass", "gradient",
            "roundStyle", "displayShadow", "coloredShadow",
            "shadowDirection",
        );
    }
    
    /**
     * @return array of widget prioprty names which are merged from skin class.
     */
    public function getMergedFields(){
        return array("options");
    }
    
    /**
     * Initializes this widget and produces the opening tags. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "div", $this->getContainerOptions());
        echo CHtml::openTag( "div", array('class' => 'msg-container'));
        if ( $this->message) echo $this->message;
    }
    
    /**
     * @return array the HTML options for the container tag. 
     */
    private function getContainerOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => "trans-msg",
            'addClass' => $this->addClass,
            'bgGradient' => $this->gradient,
            'fgColor' => $this->gradient,
            'roundStyle' => $this->roundStyle,
            'displayShadow' => $this->displayShadow,
            'shadowDirection' => $this->shadowDirection,
            'shadowGradient' => $this->gradient,
            'coloredShadow' => $this->coloredShadow,
            'style' => 'display:none'
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->options);
    }
    
    /**
     * Produces the closing tag and regsiter necessary scripts. 
     */
    public function run(){
        echo CHtml::closeTag("div");
        echo CHtml::closeTag("div");
        
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
                \$('#$this->id').transientMessage({
                    containerSelector: '$this->containerSelector',
                    iconClass: '$this->iconClass',
                    fadeInDuration: $this->fadeInDuration,
                    stayDuration: $this->stayDuration,
                    fadeOutDuration: $this->fadeOutDuration
                 });
        ");
    }
}

?>
