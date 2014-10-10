<?php

/**
 * HeroUnit is a call to action widget customizable in many different ways. Creating
 * a HeroUnit is fairly easy. You need to put the content of the HeroUnit between
 * beginWidget and endWidget call as shown below:
 * 
 * <pre>
 * 
 * <?php $this->beginWidget("ext.yiigems.widgets.heroUnit.HeroUnit", array(
 *   'title' => 'Welcome to YiiGems!'
 * ));?>
 * <p>
 * The goal of YiiGems extension is to reduce the amount of javascript and CSS
 * code you have to write to develop your application. YiiGems try to achieve this
 * by generating scripts and automatically loading predefined CSS files for your
 * widgets. While many frameworks require you to write plenty of html markups, css and 
 * javascripts, YiiGems focuses on writing minimal code on the server side.
 * </p>
 * <?php $this->widget("ext.yiigems.widgets.buttons.GradientButton", array(
 *   'label' => 'Go YiiGems',
 *   'fontSize' => 'font_size20',
 * ))?>
 * <?php $this->endWidget()?>
 * 
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.heroUnit
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.heroUnit.HeroUnitDefaults");

class HeroUnit extends AppWidget {
    /**
     * @var string Specifies the background gradient of the hero unit.
     * This property is ignored if $backgroundColor property is set. 
     */
    public $gradient;
    
    /**
     * @var string The background color of the hero unit.
     * If background color is specified, the $gradient property is ignored. 
     */
    public $backgroundColor;
    
    /**
     * @var string The round style for the four corners of the hero unit.
     */
    public $roundStyle;
    
    /**
     * @var boolean Whether shadow should be displayed for the hero unit. 
     */
    public $displayShadow;
    
    /**
     * @var string The direction of shadow of the hero unit. 
     */
    public $shadowDirection;
    
    /**
     * @var boolean Indicates whether shadow color should match gradient or background color.
     */
    public $coloredShadow;
    
    /**
     * @var string The title displayed on the hero unit.
     */
    public $title;
    
    /**
     * @var string the size of the title font. 
     */
    public $titleFontSize;
    
    /**
     * @var array the HTML options for the title for the hero unit.
     */
    public $titleOptions = array();
    
    /**
     * @var array the HTML options for the container tag of the hero unit.
     */
    public $containerOptions = array();
    
    /**
     * @var string The name of the skin class associated with the HeroUnit. 
     */
    public $skinClass = "HeroUnitDefaults";
    
    /**
     * Sets up asset information for this widget.
     * @see AppWidget::setupAssetsInfo
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addAssetInfo( "heroUnit.css", dirname(__FILE__) . "/assets" );
        $this->addGradientAssets($this->gradient);
    }
    
    /**
     * @return array the list of properties copied from skin class.
     */
    public function getCopiedFields() {
        return array(
            "gradient", "backgroundColor",
            "roundStyle", 
            "displayShadow", "shadowDirection", "coloredShadow",
            "titleFontSize"
        );
    }
    
    /**
     * @return array the list of array properties to be merged from skin class.
     */
    public function getMergedFields() {
        return array(
            "titleOptions", "containerOptions"
        );
    }

    /**
     * Initializes and produces the opening markups for this widget.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "div", $this->computeContainerOptions());
        
        // Render title only if the title is not null
        if ($this->title) {
            echo CHtml::openTag("h1", $this->computeTitleOptions());
            echo $this->title;
            echo CHtml::closeTag("h1");
        }
    }

    /**
     * @return array the options for the container element.
     */
    public function computeContainerOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => "heroUnit",
            'addClass' => $this->addClass,

            'bgColor' => $this->backgroundColor,
            'bgGradient' => $this->gradient,
            'fgColor' => $this->gradient,
            'roundStyle' => $this->roundStyle,

            'roundStyle' => $this->roundStyle,
            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,
        ));
        return ComponentUtil::mergeHtmlOptions( $options, $this->containerOptions );

//        $class = "heroUnit";
//        $style = null;
//        if ( $this->backgroundColor ){
//            $style = "background-color:$this->backgroundColor";
//        }
//        else if ( $this->gradient ){
//            $class .= " background_$this->gradient color_$this->gradient";
//        }
//
//        if ( $this->roundStyle ){
//            $class .= " {$this->roundStyle}";
//        }
//
//        if ( $this->displayShadow ){
//            if ( $this->coloredShadow && $this->gradient ){
//                $class .= " shadow_{$this->shadowDirection}_{$this->gradient}";
//            }
//            else {
//                 $class .= " shadow_{$this->shadowDirection}";
//            }
//        }

    }

    /**
     * @return array the options for the title of the hero unit.
     */
    public function computeTitleOptions(){
        $class = "";
        if ( $this->gradient ){
            $class .= " color_$this->gradient";
        }
        if ( $this->titleFontSize ){
            $class .= " $this->titleFontSize";
        }
        return array_merge(array(
            'class'=>$class
        ), $this->titleOptions );
    }

    /**
     * Produces the closing tag.
     */
    public function run(){
        echo CHtml::closeTag("div");
    }
}

?>
