<?php

/**
 * Widget to display content in a box with a title.
 * The TitleBox widget allows you to create a box with a title with arbitrary content inside the box. Just like Title widget
 * it allows setting background gradient, icon and text for the header.
 *
 * <pre>
 *
 * <?php $this->beginWidget('ext.yiigems.widgets.titleBox.TitleBox', array(
 *      'iconClass'=>'icon-beaker pull-left',
 *      'titleText' => "This is a title box with a custom gradient and icon for the header.",
 *      'headerGradient' => 'glassyTeal7',
 *      'contentGradient' => 'skyBlue1'
 * ))?>
 * [Content of the title box here]
 * <?php $this->endWidget()?>
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.titleBox
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.titleBox.TitleBoxDefaults");

class TitleBox extends AppWidget {
    /**
     * @var string the HTML tag for the container element.
     */
    public $containerTag;

    /**
     * @var string the HTML tag for the title.
     */
    public $titleTag;

    /**
     * @var string the HTML tag for the content.
     */
    public $contentTag;

    /**
     * @var string round style for the container.
     */
    public $containerRoundStyle;

    /**
     * @var array HTML tag options for the container.
     */
    public $containerOptions = array();

    /**
     * @var string the background gradient for the header.
     */
    public $headerGradient;

    /**
     * @var string the round style of the header.
     */
    public $headerRoundStyle;

    /**
     * @var string specifies header font size.
     */
    public $headerFontSize;

    /**
     * @var array HTML tag options for the header element.
     */
    public $headerOptions = array();

    /**
     * @var string the gradient background for the content area.
     */
    public $contentGradient;

    /**
     * @var string the round style for the content area.
     */
    public $contentRoundStyle;

    /**
     * @var string specifies the default font size for the content area.
     */
    public $contentFontSize;

    /**
     * @var array HTML tag options for the content area.
     */
    public $contentOptions = array();

    /**
     * @var bool specifies whether to display shadow for the content area.
     */
    public $displayShadow;

    /**
     * @var string the direction of the shadow for the box.
     */
    public $shadowDirection;

    /**
     * @var bool specifies whether the shadow should be colored based on the gradient.
     */
    public $coloredShadow;

    /**
     * @var string the icon to be used by the title box header on left.
     */
    public $leftIconClass;

    /**
     * @var string the icon to be used by the title box header on right.
     */
    public $rightIconClass;

    public $collapsible;
    public $collapseIconClass;
    public $expandIconClass;

    /**
     * @var string the text displayed at the header.
     */
    public $titleText = "<span style='color:red'>[Title Not Set]</span>";

    public $skinClass = "TitleBoxDefaults";

    /**
     * Sets up asset information for the widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();
        $this->addAssetInfo( "titleBox.css", dirname(__FILE__) . "/assets/common" );
        $this->addAssetInfo( "titleBox.js", dirname(__FILE__) . "/assets/common" );
        $this->addYiiGemsCommonCss();
        $this->addGradientAssets(array(
            $this->headerGradient, $this->contentGradient
        ));
    }

    /**
     * @return array the list of properties to be copied from current skin.
     */
    public function getCopiedFields(){
        return array(
           "containerTag", "titleTag", "contentTag",
           "containerRoundStyle",
            "headerGradient", "headerRoundStyle", "headerFontSize",
            "contentGradient", "contentRoundStyle", "contentFontSize",
            "displayShadow", "shadowDirection", "coloredShadow",
            "leftIconClass", "rightIconClass", "collapsible",
            "collapseIconClass", "expandIconClass"
        );
    }

    /**
     * @return array the list of properties to be merged from current skin.
     */
    public function getMergedFields(){
        return array(
            "containerOptions",
            "headerOptions",
            "contentOptions"
        );
    }

    public function setMemberDefaults(){
        parent::setMemberDefaults();
        if ( $this->collapsible ){
            $this->id = $this->id ? $this->id : UniqId::get("tbox-");
        }
    }

    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag($this->containerTag, $this->getContainerOptions());
        
        echo CHtml::openTag($this->titleTag, $this->getHeaderOptions());
        echo $this->getTitleText();
        echo CHtml::closeTag($this->titleTag);
        
        echo CHtml::openTag($this->contentTag, $this->getContentOptions());
    }
    
    private function getContainerOptions(){
        $cssClass = $this->addClass ? "titleBox $this->addClass" : "titleBox";
        if ( $this->containerRoundStyle ) $cssClass .= " $this->containerRoundStyle";
        if ( $this->displayShadow ) {
            if ( $this->coloredShadow ) {
                $cssClass .= " shadow_{$this->shadowDirection}_{$this->headerGradient}";
            }
            else {
                $cssClass .= " shadow_$this->shadowDirection";
            }
        }
        $options = $this->containerOptions;
        $options['class'] = $cssClass;
        $options['id'] = $this->id;
        return $options;
    }
    
    private function getHeaderOptions(){
        $cssClass = "header";
        if ( $this->headerGradient )  $cssClass .= " background_$this->headerGradient";
        if ( $this->headerGradient )  $cssClass .= " color_$this->headerGradient";
        if ( $this->headerRoundStyle ) $cssClass .= " $this->headerRoundStyle";
        if ( $this->headerFontSize ) $cssClass .= " $this->headerFontSize";
        $options = $this->headerOptions;
        $options['class'] = $cssClass;
        return $options;
    }
    
    private function getContentOptions(){
        $cssClass = "content";
        if ( $this->contentGradient )  $cssClass .= " background_$this->contentGradient";
        if ( $this->contentGradient )  $cssClass .= " color_$this->contentGradient";
        if ( $this->headerGradient )  $cssClass .= " border_$this->headerGradient";
        if ( $this->contentRoundStyle ) $cssClass .= " $this->contentRoundStyle";
        if ( $this->contentFontSize ) $cssClass .= " $this->contentFontSize";
        $options = $this->contentOptions;
        $options['class'] = $cssClass;
        return $options;
    }
    
    public function getTitleText(){
        $markup = $this->titleText;
        if ( $this->collapsible ){
            if ( $this->collapseIconClass ){
                $markup = "<span class='titleIcon {$this->collapseIconClass}'></span> " . $markup;
            }
        }
        else {
            if ( $this->leftIconClass ){
                $markup = "<span class='{$this->leftIconClass}'></span> " . $markup;
            }
        }

        if ( $this->rightIconClass ){
                $markup = $markup . " <span class='{$this->rightIconClass}'></span>";
        }
        return $markup;
    }


    public function run(){
        echo CHtml::closeTag($this->contentTag);
        echo CHtml::closeTag($this->containerTag);

        if ( $this->collapsible ){
            Yii::app()->clientScript->registerScript( UniqId::get("scr-"), "
                \$('#$this->id').titleBox({
                    expandIcon: '$this->expandIconClass',
                    collapseIcon: '$this->collapseIconClass'
                });
            ");
        }
    }
}
?>
