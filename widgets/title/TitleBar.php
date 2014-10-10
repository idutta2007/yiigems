<?php

/**
 * An widget to create a title bar.
 * The Title widget allows you to create a title bar with different background, round style and shadow characteristics.
 *
 * <pre>
 *
 * $this->widget('ext.yiigems.widgets.title.Title', array(
 *    'titleText' => "This is a title bar with default skin"
 *));
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.title
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.title.TitleBarDefaults");

class TitleBar extends AppWidget {
    /**
     * @var string the container tag for the Title widget.
     */
    public $containerTag;

    /**
     * @var string the name of the background gradient.
     */
    public $gradient;

    /**
     * @var bool whether to display shadow of the title bar.
     */
    public $displayShadow;

    /**
     * @var string the direction of the shadow.
     */
    public $shadowDirection;

    /**
     * @var bool whether to display a colored shadow.
     */
    public $coloredShadow;

    /**
     * @var the font size to be used of the title text.
     */
    public $fontSize;

    /**
     * @var string specifies the round style of the title bar.
     */
    public $roundStyle;

    /**
     * @var string specifies the icon to be used for the left side of the title bar
     */
    public $leftIconClass;

    /**
     * @var string specifies the icon to be used for the right side of the title bar
     */
    public $rightIconClass;

    /**
     * @var string specifies the text to be displayed on the title bar.
     */
    public $titleText = "<span style='color:red'>[Title Not Set]</span>";

    /**
     * @var array the HTML options for the title element.
     */
    public $options = array();

    public $skinClass = "TitleBarDefaults";

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            "title.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->gradient);
    }

    /**
     * @return array the list of properties to be copied from active skin.
     */
    public function getCopiedFields(){
        return array(
            "containerTag", "gradient",
            "displayShadow", "shadowDirection", "coloredShadow",
            "fontSize", "roundStyle", "leftIconClass", "rightIconClass"
        );
    }

    /**
     * @return array the list of properties to be merged from active skin.
     */
    public function getMergedFields(){
        return array(
            "options"
        );
    }

    /**
     * Registers all assets and produces the markup for the widget.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag($this->containerTag, $this->getTitleOptions());
        echo $this->getTitleText();
    }

    /**
     * @return array the HTML options for the title.
     */
    private function getTitleOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' =>$this->id,
            'class' =>'title',
            'addClass' =>$this->addClass,

            'bgGradient' => $this->gradient,
            'fgColor' => $this->gradient,
            'roundStyle' => $this->roundStyle,
            'fontSize' => $this->fontSize,
            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,
            'shadowGradient' => $this->gradient,
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->options);
    }

    public function getTitleText(){
        $titleText = $this->titleText;

        // Set the left icon
        if($this->leftIconClass){
            $titleText = "<span class='$this->leftIconClass'></span> $titleText";
        }

        // Set the right icon
        if($this->rightIconClass){
            $titleText = "<span class='$this->rightIconClass'></span> $titleText";
        }
        return $titleText;
    }

    /**
     *  produces the closing tag.
     */
    public function run(){
        echo CHtml::closeTag($this->containerTag);
    }
}

?>
