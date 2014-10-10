<?php

/**
 * An widget to display a simple title.
 * TitleHeader allows you to create a simple title for a section of your web page. It allows setting an icon for the
 * title but does not allow setting a background.
 *
 * <pre>
 *
 * $this->widget('ext.yiigems.widgets.title.TitleHeader', array(
 *   'titleText'=>"This is how the default title header looks like",
 * ))
 *
 * </pre>
 *
 * <pre>
 *
 * The default skin class provides three scenarios for the TitleHeader widget
 * menuHeader - suitable to display a menu header.
 * sectionHeader - suitable for displaying a header for a section of text.
 * pageHeader - suitable for displaying a page header.
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
Yii::import("ext.yiigems.widgets.title.TitleHeaderDefaults");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");

class TitleHeader extends AppWidget {
    /**
     * @var string the container tag for this widget.
     */
    public $tag;

    /**
     * @var bool whether the text should display a shadow.
     */
    public $displayShadow;

    /**
     * @var string the direction of the text shadow.
     */
    public $shadowDirection;

    /**
     * @var string specifies the font size.
     */
    public $fontSize;

    /**
     * @var string the icon to be displayed at the front of the text.
     */
    public $iconClass;

    /**
     * @var string the text to be displayed by this widget.
     */
    public $titleText = "<span style='color:red'>[Title Not Set]</span>";

    /**
     * @var the color of the text.
     * The default text color is determined by the active skin.
     */
    public $titleColor;

    /**
     * @var array the HTML options for the title header.
     */
    public $options = array();

    /**
     * @var string the name of the associated skin class.
     */
    protected $skinClass = "TitleHeaderDefaults";

    /**
     * Sets up asset information for the widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        if ($this->iconClass) {
            $this->addAssetInfo(
                "font-awesome.css", 
                $this->getCommonAssetDir()
            );
        }
        
        $this->addAssetInfo(
            "titleHeader.css",
            dirname(__FILE__) . "/assets"
        );
    }

    /**
     * @return array the list of properties copied from active skin.
     */
    protected function getCopiedFields(){
        return array(
            "tag", "displayShadow", "shadowDirection",
            "fontSize", "iconClass", "titleText", "titleColor"
        );
    }

    /**
     * @return array the list of properties copied from active skin.
     */
    protected function getMergedFields(){
        return array( "options" );
    }

    /**
     * Publishes ans registers all assets for the widget and generates markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag($this->tag, $this->getTitleOptions());
        echo $this->getTitleText();
    }

    /**
     * @return array the HTML options for the title header.
     */
    private function getTitleOptions(){
        $options = $this->options;
        
        // Set css classes
        $cssClass = "titleHeader";
        if ( $this->fontSize ) $cssClass .= " $this->fontSize";
        if ( $this->displayShadow && $this->shadowDirection ) {
            $cssClass .= " shadow_$this->shadowDirection";
        }
        $options['class'] = $cssClass;
        
        // Set style by merging from options
        $style = "";
        if ($this->titleColor) $style = "color:$this->titleColor";
        if (array_key_exists( 'style', $options) ){
            $style = StyleUtil::mergeStyles( $options['style'], $style);
        }
        if ( $style ) $options['style'] = $style;
        return $options;
    }

    /**
     * @return string the markup for the title text including the icon if any.
     */
    public function getTitleText(){
        if ( $this->iconClass ){
            $icon = CHtml::tag("span", array(
                  'class' => "$this->iconClass",
            ));
            return $this->titleText . $icon;
        }
        return $this->titleText;
    }

    /**
     * Generates the closing tag.
     */
    public function run(){
        echo CHtml::closeTag($this->tag);
    }
}

?>
