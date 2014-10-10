<?php

/**
 * The base class for ribbon widgets.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.ribbon
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");
Yii::import("ext.yiigems.widgets.ribbon.RibbonTextDefaults");
Yii::import("ext.yiigems.widgets.common.utils.GradientInfo");

class AbstractRibbon extends AppWidget{
    /**
     * @var string the name of the bar gradient.
     */
    public $barGradient;

    /**
     * @var string the color of the ribbon bar.
     * IF this property is set $barGradient property is ignored.
     */
    public $barColor;

    /**
     * @var string the direction of bar shadow.
     */
    public $barShadowDirection;

    /**
     * @var string the color of the collars in the ribbon.
     * If this property is not set, it is computed based on  $barGradient or $barColor whichever is set.
     */
    public $collarColor;

    /**
     * @var string the color of the shadow triangle.
     * If this property is not set, it is computed based on  $barGradient or $barColor whichever is set.
     */
    public $shadowTriangleColor;
    
    // The height of the ribbon
    public $height;
    
    // The width of the collar on both sides
    public $collarWidth;
    
    // The width of the collar on both sides
    public $collarTriangleWidth;
    
    // How much the collars offset vertically
    public $collarOffset;
    
    // bar offset from left and right
    public $barOffset;

    /**
     * @var int the zindex of the bar.
     */
    public $zindex = 100;

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
     * @var bool whether the left collar is visible.
     */
    public $leftCollarVisible = true;

    /**
     * @var bool whether the right collar is visible.
     */
    public $rightCollarVisible = true;

    /**
     * @var string the font size to be used for the text.
     */
    public $fontSize;

    /**
     * @var array  the HTML options for the container element.
     */
    public $options =  array();

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            "ribbon.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->barGradient);
    }

    /**
     * @return array the list of fields to be copied from current skin
     */
    public function getCopiedFields(){
        return array(
            "barGradient", "barColor", "barShadowDirection", 
            "collarColor", "shadowTriangleColor", 
            "height",  
            "collarWidth", "collarTriangleWidth", 
            "collarOffset", "barOffset", 
            "zindex", 
            "stitchesVisible", "stitchOffset", "stitchColor",
            "leftCollarVisible", "rightCollarVisible", "fontSize"
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

    /**
     * Sets the member variables to default values based on current skin.
     */
    public function setMemberDefaults(){
        parent::setMemberDefaults();
        
        $this->id = $this->id ? $this->id : UniqId::get("rbn-");
        if (!$this->collarTriangleWidth) {
            $this->collarTriangleWidth = StyleUtil::getHalf($this->collarWidth);
        }
        if (!$this->collarColor) {
            if ($this->barColor){
                $this->collarColor = $this->barColor;
            }
            else if( $this->barGradient ){
                $this->collarColor = GradientInfo::getLastColor($this->barGradient);
            }
        }
    }

    /**
     * Initializes the widget and generates the markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag("div", $this->getContainerOptions());
        echo CHtml::openTag("div", $this->getInnerContainerOptions());
        echo CHtml::openTag("div", $this->getContentOptions());
    }
    
    public function getContainerOptions(){
        $class = "ribbon";
        $height = StyleUtil::getSum($this->height, $this->collarOffset);
        $style = StyleUtil::createStyle(array(
            'height'=>$height
        ));
        return array_merge( array(
            'class'=>$class,
            'style'=>$style
        ), $this->options );
    }

    /**
     * @return array the HTML options for the inner container.
     */
    public function getInnerContainerOptions(){
        $height = StyleUtil::getSum($this->height, $this->collarOffset);
        $style = StyleUtil::createStyle(array(
            'height'=>$height
        ));
        return array(
            'class'=>"innerDiv",
            'style'=>$style
        );
    }

    /**
     * @return array HTML options for the ribbon content.
     */
    public function getContentOptions(){
        $class = "ribbonContent";
        if ( $this->barColor ){
            $class .= " $this->barGradient";
        }
        else if ( $this->barGradient ){
            $class .= " background_$this->barGradient";
        }
        if ( $this->barShadowDirection ){
            $class .= " shadow_$this->barShadowDirection";
        }
        if ( $this->fontSize ){
            $class .= " $this->fontSize";
        }
        $style = StyleUtil::createStyle(array(
            'background-color'=>$this->barColor,
            'height' => $this->height,
            'line-height' => $this->height,
            'left' => $this->barOffset,
            'right' => $this->barOffset,
            'z-index'=> $this->zindex + 1
        ));
        return array(
            'class'=>$class,
            'style'=>$style,
        );
    }

    /**
     * @param $location specifies the location of the collar - which is "left" or "right".
     * @return array the HTML options for the right and left collars.
     */
    public function getCollarOptions($location){
        $class = $location == "left" ? "leftCollar" : "rightCollar";
        $borderLeftColor = $location == "left" ? "transparent" : null;
        $borderRightColor = $location == "right" ? "transparent" : null;
        $style = StyleUtil::createStyle(array(
            'top' => $this->collarOffset,
            'border-color' => $this->collarColor,
            'border-left-color' => $borderLeftColor,
            'border-right-color' => $borderRightColor,
            'border-width' => $this->getCollarBorderWidths($location),
            'z-index'=> $this->zindex
        ));
        return array(
            'class'=>$class,
            'style'=>$style,
        );
    }

    /**
     * @param $location specifies the collar - which is "left" or "right"
     * @return string returns the CSS border width of the collars based on location.
     */
    public function getCollarBorderWidths($location){
        $top =  StyleUtil::getHalf( $this->height );
        $bottom = $top;
        $left =  $this->collarTriangleWidth;
        $right =  StyleUtil::getDiff( $this->collarWidth, $this->collarTriangleWidth );
        if ( $location == "left") return "$top $right $bottom $left";
        return "$top $left $bottom $right";
    }

    /**
     * Generates the colosing tag of the ribbon widget.
     */
    public function run(){
        echo CHtml::closeTag("div");
        
        if ($this->leftCollarVisible) {
            echo CHtml::openTag("div", $this->getCollarOptions("left"));
            echo CHtml::closeTag("div");
        }
        
        if ($this->rightCollarVisible) {
            echo CHtml::openTag("div", $this->getCollarOptions("right"));
            echo CHtml::closeTag("div");
        }
        
        if ($this->stitchesVisible) {
            echo CHtml::openTag("div", $this->getStichOptions("top"));
            echo CHtml::closeTag("div");
            echo CHtml::openTag("div", $this->getStichOptions("bottom"));
            echo CHtml::closeTag("div");
        }
        
        // Left shadow triangle
        echo CHtml::openTag("div", $this->getShadowTriangleOptions("left"));
        echo CHtml::closeTag("div");
        
        // Right shadow triangle
        echo CHtml::openTag("div", $this->getShadowTriangleOptions("right"));
        echo CHtml::closeTag("div");
        
        echo CHtml::closeTag("div");
        echo CHtml::closeTag("div");
    }

    /**
     * @param $location specifies the trainagle which is "left" or "right".
     * @return array the HTML options for the shadow triangles.
     */
    private function getShadowTriangleOptions($location){
        $width = StyleUtil::getDiff($this->collarWidth, $this->barOffset);
        $height = $this->collarOffset;
        $top = $this->height;
        $left = null;
        $right = null;
        if ($location == "left"){
            $left = $this->barOffset;
            $borderWidth = "0 $width $height 0";
            $borderColor = "transparent $this->shadowTriangleColor transparent transparent";
        }
        else {
            $right = $this->barOffset;
            $borderWidth = "0 0 $height $width";
            $borderColor = "transparent  transparent transparent $this->shadowTriangleColor";
        }
        $style = StyleUtil::createStyle(array(
            'left'=> $left,
            'right'=> $right,
            'top'=> $top,
            'border-width'=>$borderWidth,
            'border-color'=>$borderColor,
            'z-index'=> $this->zindex + 1
        ));
        return array(
            'class'=>'triangleLeft',
            'style'=>$style
        );
    }

    /**
     * @param $location of the stitch which is "top" or "bottom".
     * @return array computes the location of the stitch based on location.
     */
    public function getStichOptions($location) {
        $top = null;
        $bottom = null;
        $left = $this->barOffset;
        $right = $this->barOffset;
        if ($location == "top" ){
            $class = "stitchTop";
            $top = $this->stitchOffset;
        }
        else if ( $location == "bottom"){
            $class = "stitchBottom";
            $top = StyleUtil::getDiff($this->height, $this->stitchOffset );
        }
        
        $style = StyleUtil::createStyle(array(
            'top'=>$top,
            'bottom'=>$bottom,
            'left'=>$left,
            'right'=>$right,
            'border-color'=>$this->stitchColor,
            'z-index'=>$this->zindex + 2
        ));
        return array(
            'class'=>$class,
            'style'=>$style
        );
    }
}

?>
