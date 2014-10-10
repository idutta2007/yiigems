<?php

/**
 * An widget to display progress bars.
 * The ProgressBar widget displays a striped and animated progress bar to the end user.
 *
 * <pre>
 *
 * <?php $this->widget("ext.yiigems.widgets.progressBar.ProgressBar", array(
 *    'id'=>'pb',
 *    'barWidth'=>"75%"
 * ));?>
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.progressBar
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class ProgressBar extends AppWidget {
    /**
     * @var string the color of the progress bar.
     * If this property is set, $containerGradient property is ignored.
     */
    public $containerColor;

    /**
     * @var The background gradient of the progress bar.
     * If $containerColor is set to a non-null value, this property will be ignored.
     */
    public $containerGradient;

    /**
     * @var string the color of the bar.
     * If this property is set, then $barGradient is ignored.
     */
    public $barColor;

    /**
     * The name of the gradient used for the bar.
     * If $barColor is set, then this property is ignored.
    */
    public $barGradient;

    /**
     * @var string The round style for the entire progress bar.
     */
    public $containerRoundStyle = "big_round";

    /**
     * @var string the round style of the bar.
     */
    public $barRoundStyle = "big_round_left";

    /**
     * @var bool Specifies whether a shadow should be displayed for the progress bar.
     */
    public $displayContainerShadow = true;

    /**
     * @var string specifies the direction of the shadow for the progress bar.
     */
    public $containerShadowDirection = "bottom_right";

    /**
     * @var bool specifies whether shadow should be colored.
     */
    public $displayColoredContainerShadow = false;

    /**
     * @var bool whether the bar inside the progress bar should display a shadow.
     */
    public $displayBarShadow = false;

    /**
     * @var string The direction of the shadow associated with the bar.
     */
    public $barShadowDirection = "bottom_right";

    /**
     * @var bool whether the shadow associated with the bar should be colored.
     */
    public $displayColoredBarShadow = false;

    /**
     * @var string the height of the bar.
     */
    public $barHeight = "1.5em";

    /**
     * @var string the width of the bar.
     * This is typically expressed in percentage units.
     */
    public $barWidth = "50%";

    /**
     * @var bool specifies whether the bar should display the stripes on it.
     */
    public $striped=null;

    /**
     * @var bool specifies whether the stripes should be animated.
     */
    public $animated=null;

    /**
     *  @var array The HTML options for the container element.
    */
    public $containerOptions;

    /**
     * @var array the HTML options for the bar element.
     */
    public $barOptions = array();

    /**
     * @var string the skin class associated with this widget.
     */
    public $skinClass = "ProgressBarDefaults";

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addAssetInfo(
            "progressBar.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets(array(
            $this->containerColor,
            $this->containerGradient,
            $this->barColor,
            $this->barGradient,
        ));
    }

    /**
     * @return array the list of fields which are copied from the active skin.
     */
    public function getCopiedFields(){
        return array(
            "containerColor", "containerGradient", "barColor", "barGradient",
            "containerRoundStyle", "barRoundStyle",
            "displayContainerShadow", "containerShadowDirection", "displayColoredContainerShadow",
            "displayBarShadow", "barShadowDirection", "displayColoredBarShadow",
            "barHeight", "barWidth", "striped", "animated",
        );
    }

    /**
     * @return array the list of properties merged from the active skin.
     */
    public function getMergedFields(){
        return array(
            "containerOptions", "barOptions"
        );
    }

    /**
     * Sets the default values for its properties.
     */
    public function setMemberDefaults() {
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get( "pb-");
    }

    /**
     * Initializes this widget by registering assets and then producing all markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag("div", $this->getContainerOptions());
        echo CHtml::openTag("div", $this->getBarOptions());
        echo CHtml::openTag("div", $this->getStripeOptions());
        echo CHtml::closeTag("div");
        echo CHtml::closeTag("div");
        echo CHtml::closeTag("div");
    }

    /**
     * @return array the HTML options for the container element.
     */
    private function getContainerOptions(){
        $class = "progressBar";
        
        // set color and gradient
        if ( $this->containerColor ){
            $class .= " background_color_{$this->containerColor}";
        }
        else if ( $this->containerGradient ){
            $class .= " background_{$this->containerGradient}";
        }
        
        // Set shadow
        if ( $this->displayBarShadow ){
            if ( $this->displayColoredBarShadow ) {
                $class .= " shadow_{$this->barShadowDirection}_{$this->barGradient}";
            }
            else {
                $class .= " shadow_$this->barShadowDirection";
            }
        }
        
        // set round style
        if ( $this->containerRoundStyle ){
            $class .= " $this->containerRoundStyle";
        }
        
        return array_merge($this->containerOptions, array(
            'id'=>$this->id,
            'class'=>$class,
            
        ));
    }

    /**
     * @return array the HTML options for the bar.
     */
    private function getBarOptions(){
        $class = "";
        
        // set gradient
        if ( $this->barColor ){
            $class .= " background_color_{$this->barColor}";
        }
        else if ( $this->barGradient ){
            $class .= " background_{$this->barGradient}";
        }
        
        // Set shadow
        if ( $this->displayBarShadow ){
            if ( $this->displayColoredBarShadow ) {
                $class .= " shadow_{$this->barShadowDirection}_{$this->barGradient}";
            }
            else {
                $class .= " shadow_$this->barShadowDirection";
            }
        }
        
        // set round style
        if ( $this->barRoundStyle ){
            $class .= " $this->barRoundStyle";
        }
        
        return array(
            'class'=>$class,
            'style'=>"width:$this->barWidth;height:$this->barHeight"
        );
    }

    /**
     * @return array The HTML options for stripe.
     */
    public function getStripeOptions(){
        $class = "";
        
        if ( $this->striped){
            $class .= " striped";
        }
        if ( $this->animated){
            $class .= " animated";
        }
        if ( $this->barRoundStyle ){
            $class .= " $this->barRoundStyle";
        }
        return array(
            'class'=>$class,
            'style'=>"height:$this->barHeight"
        );
    }
}

?>
