<?php

/**
 * Description of DiagonalRibbon
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.ribbon
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.ribbon.DiagonalRibbonDefaults");

class DiagonalRibbon extends AppWidget {
    /**
     * @var string the name of the bar gradient.
     */
    public $barGradient;

    /**
     * @var string the color of the ribbon bar.
     * IF this property is set $barGradient property is ignored.
     */
    public $barColor;

    // The height of the ribbon
    public $width;
    public $height;
    public $top;
    public $bottom;
    public $left;
    public $right;
    
    /** The location of the dialoganl ribbon.  */
    public $location;
    
    /** Whether shadow to be displayed for the ribbon */
    public $displayShadow;

    /** The direction of the shadow specified as left, right, top, bottom, bottom_right, bottom_left or expand. */
    public $shadowDirection;

     /** Whether colored shadow should be displayed */
    public $coloredShadow;

    /**
     * @var bool Specifies whether the stitches are visible or not.
     */
    public $stitchesVisible = true;

    /**
     * @var string the offset of the stitches from top or bottom margins.
     */
    public $stitchOffset;

    /**
     * @var string the default color for the stitches.
     */
    public $stitchColor;

    /**
     * @var string the font size to be used for the text.
     */
    public $fontSize;
    
    /**
     * @var int the zindex of the bar.
     */
    public $zindex = 100;

    /**
     * @var array  the HTML options for the container element.
     */
    public $options =  array();
    
    public $skinClass = "DiagonalRibbonDefaults";
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "diagRibbon.css", dirname(__FILE__) . "/assets" );
        $this->addGradientAssets($this->barGradient);
    }
    
    /**
     * @return array the list of fields to be copied from current skin
     */
    public function getCopiedFields(){
        return array(
            "barGradient", "barColor",  "width", "height",
            "location", "top", "bottom", "left", "right",
            "displayShadow", "shadowDirection", "coloredShadow",
            "stitchesVisible", "stitchOffset", "stitchColor",
            "fontSize", "zindex", 
        );
    }

    /**
     * @return array the list of properties to be merged from current skin.
     */
    public function getMergedFields(){
        return array(
            "options"
        );
    }
    
    public function setMemberDefaults(){
        parent::setMemberDefaults();
        
        // compute positions if not given
        if ($this->location == "topLeft"){
            if (!$this->top && !$this->left && $this->width && $this->height ){
                $this->top =  StyleUtil::getDiff( StyleUtil::getScaledLength( $this->width, 0.707 ), $this->height);
                $this->left = "0px";
            }
        }
        else if ($this->location == "topRight"){
            if (!$this->top && !$this->right && $this->width && $this->height ){
                $this->top =  StyleUtil::getDiff( StyleUtil::getScaledLength( $this->width, 0.707 ), $this->height);
                $this->right = "0px";
            }
        }
        else if ($this->location == "bottomLeft"){
            if (!$this->bottom && !$this->left && $this->width && $this->height ){
                $this->bottom =  StyleUtil::getDiff( StyleUtil::getScaledLength( $this->width, 0.707 ), $this->height);
                $this->left = "0px";
            }
        }
        else if ($this->location == "bottomRight"){
            if (!$this->bottom && !$this->right && $this->width && $this->height ){
                $this->bottom =  StyleUtil::getDiff( StyleUtil::getScaledLength( $this->width, 0.707 ), $this->height);
                $this->right = "0px";
            }
        }
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag("div", $this->getContainerOptions());
        echo CHtml::openTag("div", $this->getInnerContainerOptions());
    }
    
    public function getContainerOptions(){
        $opts = ComponentUtil::computeHtmlOptions(array(
            'class' => "diagRibbon $this->location",
            'addClass' => $this->addClass,
            'bgGradient' => $this->barGradient,
            'bgColor' => $this->barColor,
            'fgColor' => $this->barGradient,
            'hoverFgColor' => $this->barGradient,
            'displayShadow'=> $this->displayShadow,
            'shadowDirection'=> $this->shadowDirection,
            'coloredShadow'=> $this->coloredShadow,
            'fontSize' => $this->fontSize,
            'style' => $this->getContainerStyle()
        ));
        return ComponentUtil::mergeHtmlOptions($opts, $this->options);
    }
    
    public function getContainerStyle(){
        if ($this->location == "topLeft" ) {
            return "left:$this->left;top:$this->top;width:$this->width;height:$this->height";
        }
        else if ($this->location == "topRight" ) {
            return "right:$this->right;top:$this->top;width:$this->width;height:$this->height";
        }
        else if ($this->location == "bottomLeft" ) {
            return "left:$this->left;bottom:$this->bottom;width:$this->width;height:$this->height";
        }
        else if ($this->location == "bottomRight" ) {
            return "right:$this->right;bottom:$this->bottom;width:$this->width;height:$this->height";
        }
    }

    public function getInnerContainerOptions() {
         return array(
             'class' => "innerCont", 
             'style' => "position:relative;height:$this->height;line-height:$this->height"
         );
    }
    
    public function run(){
        if ( $this->stitchesVisible ){
            echo CHtml::openTag("div", $this->getStitchOptions("top"));
            echo CHtml::closeTag("div");
            echo CHtml::openTag("div", $this->getStitchOptions("bottom"));
            echo CHtml::closeTag("div");
        }
        echo CHtml::closeTag( "div" );
        echo CHtml::closeTag( "div" );
    }
    
    /**
     * @param $location of the stitch which is "top" or "bottom".
     * @return array computes the location of the stitch based on location.
     */
     public function getStitchOptions($location) {
        $cssClass = null;
        $top = null;
        $bottom = null;

        if ($location == "top" ){
            $cssClass = "stitchTop";
            $top = $this->stitchOffset;
        }
        else if ( $location == "bottom"){
            $cssClass = "stitchBottom";
            $bottom = $this->stitchOffset;
        }

        $style = StyleUtil::createStyle(array(
                'position'=> "absolute",
                'top'=> $top,
                'bottom'=> $bottom,
                'width'=> $this->width,
                'border-color'=> $this->stitchColor,
                'z-index'=> $this->zindex + 2
        ));
        return array('class'=> $cssClass, 'style'=> $style );
    }
}

?>
