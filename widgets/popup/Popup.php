<?php

/**
 * Description of Popup
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.popup
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import( "ext.yiigems.widgets.common.AppWidget");
Yii::import( "ext.yiigems.widgets.popup.PopupDefaults");
Yii::import( "ext.yiigems.widgets.common.utils.RoundStyleUtil");

class Popup extends AppWidget {
    public $roundStyle;
    public $fontSize;
    public $displayShadow;
    public $shadowDirection;
    public $popupOptions = array();
    public $contentOptions = array();
    
    // Header text and options
    public $headerText;
    public $headerOptions = array();
    
    /** The JQuery selector for the element relative to which the popup is placed */
    public $target;
    public $location;
    
    public $closable = true;
    
    public $skinClass = "PopupDefaults";
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        JQueryUI::registerYiiJQueryUIResources();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "popup.css", dirname(__FILE__) . "/assets");
        $this->addAssetInfo( "popup.js", dirname(__FILE__) . "/assets");
    }
    
    protected function getCopiedFields() {
       return array(
           "location", "roundStyle", "fontSize", "displayShadow", "shadowDirection"
       );
    }
    
    protected function getMergedFields() {
        return array(
           "popupOptions", "contentOptions", "headerOptions"
       );
    }
    
    protected function setMemberDefaults() {
        parent::setMemberDefaults();
    }
    
    public function init() {
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "div", $this->computePopupOptions());
        if ( $this->closable ) $this->renderCloseIcon();
        if ( $this->headerText ) $this->renderHeader();
        echo CHtml::openTag( "div", $this->computeContentOptions());
    }
    
    public function renderHeader(){
        echo CHtml::openTag("h2", $this->computeHeaderOptions());
        echo $this->headerText;
        echo CHtml::closeTag( "h2");
    }
    
    public function renderCloseIcon(){
        echo "<span class='closeIcon icon-remove'></span>";
    }
    
    public function computePopupOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => "x-" . $this->id,
            'class' => "popup $this->location",
            'addClass' => $this->addClass,
            'roundStyle' => $this->roundStyle,
            'fontSize' => $this->fontSize,
            'displayShadow' => $this->displayShadow,
            'shadowDirection' => $this->shadowDirection,
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->popupOptions );
    }
    
    public function computeContentOptions(){
        return $this->contentOptions;
    }
    
    public function computeHeaderOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'class' => 'header',
            'roundStyle' => RoundStyleUtil::getTopRoundStyle($this->roundStyle)
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->headerOptions );
    }
    
    public function run(){
       echo CHtml::closeTag("div"); 
       echo CHtml::closeTag("div"); 
       
       $closable = $this->closable? 'true' : 'false';
       Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
           $('#x-$this->id').popup({
               popupId: '$this->id',
               location: '$this->location',
               target: '$this->target',
               closable: $closable
           });
       ");
    }
}

?>
