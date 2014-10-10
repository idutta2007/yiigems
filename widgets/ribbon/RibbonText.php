<?php

/**
 * An widget to display a text on a ribbon.
 *
 * The RibbonText widget allows you to display a simple text on ribbon bar. It allows changing the background color or
 * gradient of the bar, the color of the collars or the shadow area of the button.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.ribbon
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.ribbon.RibbonTextDefaults");
Yii::import("ext.yiigems.widgets.ribbon.AbstractRibbon");

class RibbonText extends AbstractRibbon {
    /**
     * @var string the text to be displayed on the ribbon bar.
     */
    public $text;
    
    /**
     * @var string the icon to be placed in front of the text.
     */
    public $iconClass;

    /**
     * @var string the skin class associated with the widget.
     */
    public $skinClass = "RibbonTextDefaults";

    /**
     * Registers the assets for this widget and generates all markups.
     */
    public function init(){
        parent::init();
        echo CHtml::openTag("h2", array('class'=>"bannerText"));
        echo $this->getTextMarkup();
        echo CHtml::closeTag("h2");
    }
    
    private function getTextMarkup(){
        if ( $this->iconClass){
            return "<span class='$this->iconClass'></span>$this->text";
        }
        return $this->text;
    }
}

?>
