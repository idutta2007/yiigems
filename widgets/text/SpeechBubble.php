<?php

/**
 * An widget to display SpeechBubble. The SpeechBubble allows any HTML content to be wrapped inside a speech bubble
 * on your web page. It provides properties to set the background, the location, shape and direction of the triangle
 * associated with the speech bubble.
 *
 * <pre>
 *
 * <?php $this->beginWidget("ext.yiigems.widgets.text.SpeechBubble", array(
 *    'backgroundColor' => 'oliveDrab1',
 *    'location'=>'bottom',
 *    'left'=>'3em',
 *    'shape'=>'rightAngled',
 *    'slopeLocation'=>'left',
 *    'triangleWidth'=>'2em',
 *    'triangleHeight'=>'3em',
 * ))?>
 * <p style="color:#333">
 * YiiGems provides a flexible Speech Bubble widget to display conversational contents
 * in an elegant way. It provides a lot of control over the shape, position and orientation
 * of the triangle.
 * </p>
 * <?php $this->endWidget()?>
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.speechBubble
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");
Yii::import("ext.yiigems.widgets.common.utils.GradientInfo");
Yii::import("ext.yiigems.widgets.text.SpeechBubbleDefaults");

class SpeechBubble extends AppWidget {
    /**
     * @var string the HTML tag used by this widget.
     */
    public $htmlTag;

    /**
     * @var array the list of options for the container tag of the speech bubble.
     */
    public $htmlOptions = array();

    /**
     * @var string the background color of the speech bubble.
     */
    public $backgroundColor;

    /**
     * @var string the background gradient of the speech bubble.
     * This property will be ignored if $backgroundColor is set.
     */
    public $gradient;

    /**
     * The width of the border
     */
    public $borderWidth;

    /**
     * @var the color of the border.
     */
    public $borderColor;

    /**
     * @var the default size of fonts in speech bubble content.
     */
    public $fontSize;

    /**
     * @var string the round style of the speech bubble.
     */
    public $roundStyle;

    /**
     * @var specified whether to display a shadow for the speech bubble.
     */
    public $displayShadow;

    /**
     * @var whether to display a colored shadow instead of gray shadow.
     */
    public $coloredShadow;

    /**
     * @var the direction of shadow - bottom_right, bottom etc.
     */
    public $shadowDirection;

    /**
     * @var string The location of the pointer of the speech bubble.
     */
    public $triangleLocation;

    /**
     * @var string the shape of the pointer.
     * The allowed values are "iso" and "rightAngled".
     */
    public $triangleType;

    /**
     * The location of the slope of the triangle if the pointer shape is rightAngled.
     * Possible values ate left, right, top, bottom
     */
     public $raSlopeLocation;

    /**
     * @var string the height of the triangle in  CSS units.
     */
    public $triangleHeight;

    /**
     * @var string specifies the width of the triangle in CSS units.
     */
    public $triangleWidth;


    /**
     * @var string left position of the pointer.
     */
    public $triangleLeft;

    /**
     * @var string top position of the pointer.
     */
    public $triangleTop;

    /**
     * @var string bottom position of the pointer.
     */
    public $triangleBottom ;

    /**
     * @var string right position of the pointer.
     */
    public $triangleRight;

    public $skinClass = "SpeechBubbleDefaults";


    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addAssetInfo(
            "speechBubble.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets( array(  $this->gradient ));
    }

    protected function getCopiedFields(){
        return array(
            "htmlTag", "backgroundColor", "gradient", "borderWidth",
            "borderColor", "fontSize", "roundStyle", "displayShadow",
            "coloredShadow", "shadowDirection", "triangleLocation", "triangleType",
            "raSlopeLocation", "triangleHeight", "triangleWidth"
        );
    }

    protected function getMergedFields(){
        return array( "htmlOptions" );
    }

    /**
     * Sets the properties values to default based on active skin.
     */
    public function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("sb-");
    }

    /**
     * Registers all assets and produces the starting markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();

        echo CHtml::openTag( $this->htmlTag, $this->getBubbleOptions());
    }

    /**
     * Produces the closing tags.
     */
    public function run(){
        echo CHtml::openTag("div", $this->computeOuterTriangleOptions());
        echo CHtml::closeTag("div");

        // Inner triangle is drawn only if borderWidth is set
        if ($this->borderWidth ){
            echo CHtml::openTag("div", $this->computeInnerTriangleOptions());
            echo CHtml::closeTag("div");
        }

        echo CHtml::closeTag( $this->htmlTag );

        $my = null;
        $at = null;
        $of = "#{$this->id}";

        if ( $this->triangleLocation == "top"){
            $pos = $this->triangleLeft ? "left+$this->triangleLeft" : "center";
            $my = $this->borderWidth ? "center bottom+$this->borderWidth" : "center bottom";
            $at = "$pos top";
        }
        else if ($this->triangleLocation == "bottom" ){
            $pos = $this->triangleLeft ? "left+$this->triangleLeft" : "center";
            $my = $this->borderWidth ? "center top-$this->borderWidth" : "center top";
            $at = "$pos bottom";
        }
        else if ($this->triangleLocation == "left" ){
            $pos = $this->triangleTop ? "top+$this->triangleTop" : "center";
            $my = $this->borderWidth ? "right+$this->borderWidth center" : "right center";
            $at = "left $pos";
        }
        else if ($this->triangleLocation == "right" ){
            $pos = $this->triangleTop ? "top+$this->triangleTop" : "center";
            $my = $this->borderWidth ? "left-$this->borderWidth center" : "left center";
            $at = "right $pos";
        }

        Yii::app()->clientScript->registerScript( UniqId::get("src-"), "
           \$('#{$this->id} .outer').position({
               my: '$my',
               at: '$at',
               of: '$of',
               collision: 'none none'
           });

           \$('#{$this->id} .inner').position({
                my: '$my',
                at: '$at',
                of: '$of',
                collision: 'none none'
           });
        ");
    }

    private function getBubbleOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => "speechBubble",
            'addClass' => $this->addClass,

             "bgColor" => $this->backgroundColor,
             "bgGradient" => $this->gradient,

             "fgColor" => $this->gradient,

             "roundStyle" => $this->roundStyle,
             "fontSize" => $this->fontSize,

             "displayShadow" => $this->displayShadow,
             "coloredShadow" => $this->coloredShadow,
             "shadowDirection" => $this->shadowDirection,
        ));

        // merge border color and width
        $options['style'] = array_key_exists( "style", $options) ? $options['style'] : array();
        $options['style'] = StyleUtil::mergeStyles($options['style'], "border-width:{$this->borderWidth}px;border-color:$this->borderColor");

        // merge margin rules
        $options['style'] = StyleUtil::mergeStyles( $options['style'], $this->computeBubbleMarginRules() );

        return  ComponentUtil::mergeHtmlOptions( $options, $this->htmlOptions );
    }

    private function computeBubbleMarginRules(){
        if ( $this->triangleLocation == "left"){
            return "margin-left:$this->triangleWidth" . "px";
        }
        else if ( $this->triangleLocation == "right"){
            return "margin-right:$this->triangleWidth" . "px";
        }
        else if ( $this->triangleLocation == "top"){
            return "margin-top:$this->triangleHeight" . "px";
        }
        else if ( $this->triangleLocation == "bottom"){
            return "margin-bottom:$this->triangleHeight" . "px";
        }
        return null;
    }

    private function computeOuterTriangleOptions(){
        $cssClass = "triangle outer";

        $borderRules = $this->computeTriangleBorderRules( $this->triangleWidth, $this->triangleHeight, $this->computeOuterTriangleColor() );
        $style = StyleUtil::createStyle($borderRules);

        return array('class'=>$cssClass, 'style'=>$style);
    }

    private function computeOuterTriangleColor(){
        if ($this->borderWidth ){
            return $this->borderColor;
        }
        else if ( $this->backgroundColor ){
            return $this->backgroundColor;
        }
        else if ($this->gradient ){
            if ( $this->triangleLocation == "top" ){
                return GradientInfo::getFirstColor( $this->gradient );
            }
            else if ( $this->triangleLocation == "bottom" ){
                return GradientInfo::getLastColor( $this->gradient );
            }
            else if ( $this->triangleLocation == "left" ){
                return GradientInfo::getBackgroundColor( $this->gradient );
            }
            else if ( $this->triangleLocation == "right" ){
                return GradientInfo::getBackgroundColor( $this->gradient );
            }
        }
        return "gray"; // if nothing was found
    }

    private function computeInnerTriangleOptions(){
        $cssClass = "triangle inner";

        $w = (double)$this->triangleWidth;
        $h = (double)$this->triangleHeight;
        $bw = (double)$this->borderWidth;

        $width = 0;
        $height = 0;
        if ( $this->triangleLocation == "top" || $this->triangleLocation == "bottom" ){
            if ($this->triangleType == "ra" ){
                $width = $w - $bw - ($bw * sqrt( $w*$w + $h*$h)) /$h;
                $height = ($width*$h)/$w;
            }
            else {
                $width = $w - 2 * ($bw * sqrt( $w*$w/4.0 + $h*$h)) / $h;
                $height =  ($width * $h) /$w;
            }
        }
        else if ( $this->triangleLocation == "left" || $this->triangleLocation == "right" ){
            if ( $this->triangleType == "ra" ){
                $height = $h - $bw - ($bw * sqrt( $w*$w + $h*$h)) / $w;
                $width = ($height * $w) /$h;
            }
            else {
                $height = $h - 2 * ($bw * sqrt( $w*$w + $h*$h / 4.0)) / $w;
                $width = ($height * $w)/$h;
            }
        }
        $borderRules = $this->computeTriangleBorderRules($width, $height, $this->computeInnerTriangleColor() );
        $style = StyleUtil::createStyle($borderRules);

        return array( 'class'=>$cssClass, 'style'=>$style);
    }

    private function computeInnerTriangleColor(){
        if ($this->backgroundColor) {
            return $this->backgroundColor;
        }
        else if ($this->gradient){
            if ( $this->triangleLocation == "top" ){
                return GradientInfo::getFirstColor($this->gradient);
            }
            else if ( $this->triangleLocation == "bottom" ){
                return GradientInfo::getLastColor($this->gradient);
            }
            else if ( $this->triangleLocation == "left" ){
                return GradientInfo::getBackgroundColor($this->gradient);
            }
            else if ( $this->triangleLocation == "right" ){
                return GradientInfo::getBackgroundColor($this->gradient);
            }
        }
        return "transparent"; // if nothing was found
    }

    private function computeTriangleBorderRules($width, $height, $bgColor){
        $fullWidth = round($width, 2) . "px";
        $fullHeight = round($height, 2) . "px";
        $halfWidth = round($width/2.0, 2) . "px";
        $halfHeight = round($height/2.0, 2) . "px";

        $style = array();
        if ( $this->triangleLocation == "top"){
            if ( $this->triangleType == "iso" ){
                $style["border-width"] = "0 $halfWidth $fullHeight $halfWidth";
                $style["border-color"] = "transparent transparent $bgColor transparent";
            }
            else {
                if ( $this->raSlopeLocation == "left" ){
                    $style["border-width"] = "0 0 $fullHeight $fullWidth";
                    $style["border-color"] = "transparent transparent $bgColor transparent";
                }
                else {
                    $style["border-width"] = "0 $fullWidth $fullHeight 0";
                    $style["border-color"] = "transparent transparent $bgColor transparent";
                }
            }
        }
        else if ( $this->triangleLocation == "bottom"){
            if ( $this->triangleType == "iso" ){
                $style["border-width"]= "$fullHeight $halfWidth 0 $halfWidth";
                $style["border-color"] = "$bgColor transparent transparent transparent";
            }
            else {
                if ( $this->raSlopeLocation == "left" ){
                    $style["border-width"] = "$fullHeight 0 0 $fullWidth";
                    $style["border-color"] = "$bgColor transparent transparent transparent";
                }
                else {
                    $style["border-width"] = "$fullHeight $fullWidth 0 0";
                    $style["border-color"] = "$bgColor transparent transparent transparent";
                }
            }
        }
        else if ( $this->triangleLocation == "left"){
            if ( $this->triangleType == "iso" ){
                $style["border-width"] = "$halfHeight $fullWidth $halfHeight 0";
                $style["border-color"] = "transparent $bgColor transparent transparent";
            }
            else {
                if ( $this->raSlopeLocation == "top" ){
                    $style["border-width"] = "$fullHeight $fullWidth 0 0";
                    $style["border-color"] = "transparent $bgColor transparent transparent";
                }
                else {
                    $style["border-width"] = "0 $fullWidth $fullHeight 0";
                    $style["border-color"] = "transparent $bgColor transparent transparent";
                }
            }
        }
        else if ( $this->triangleLocation == "right"){
            if ( $this->triangleType == "iso" ){
                $style["border-width"] = "$halfHeight 0 $halfHeight $fullWidth";
                $style["border-color"] = "transparent transparent transparent $bgColor";
            }
            else {
                if ( $this->raSlopeLocation == "top" ){
                    $style["border-width"] = "$fullHeight 0 0 $fullWidth";
                    $style["border-color"] = "transparent transparent transparent $bgColor";
                }
                else {
                    $style["border-width"] = "0 0 $fullHeight $fullWidth";
                    $style["border-color"] = "transparent transparent transparent $bgColor";
                }
            }
        }
        return $style;
    }
}

?>
