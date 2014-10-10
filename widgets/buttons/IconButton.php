<?php
/**
 * Widget to create a button with a single icon. Icon button is derived from GradientButton and has many similar
 * functionality.
 *
 * <pre>
 *
 * $this->widget("ext.yiigems.widgets.buttons.IconButton", array(
 *    'gradient' => 'aquaAliceBlue1',
 *    'url' => "javascript:void(0)"
 * ));
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.buttons
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.buttons.GradientButton");
Yii::import("ext.yiigems.widgets.buttons.IconButtonDefaults");
Yii::import("ext.yiigems.widgets.common.utils.GradientUtil");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");

class IconButton extends GradientButton {
    public $skinClass = "IconButtonDefaults";
    
    public $buttonCssFile = "iconButton.css";
    public $buttonClass = "iconButton";

    public function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id =  $this->id ? $this->id : UniqId::get("ib-");
    }

    /**
     * @return array the HTML options for the button tag.
     */
    protected function getButtonOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => $this->buttonClass,
            'addClass' => $this->addClass,
            'selected' => $this->selected,

            'bgGradient' => $this->gradient,
            'hoverBgGradient' => $this->hoverGradient,
            'activeBgGradient' => $this->activeGradient,
            'selectedBgGradient' => $this->selectedGradient,

            'fgColor' => $this->gradient,
            'hoverFgColor' => $this->hoverGradient,
            'activeFgColor' => $this->activeGradient,
            'selectedFgColor' => $this->selectedGradient,

            'borderGradient' => $this->gradient,
            'hoverBorderGradient' => $this->hoverGradient,
            'activeBorderGradient' => $this->activeGradient,
            'selectedBorderGradient' => $this->selectedGradient,

            'borderStyle' => $this->borderStyle,
            'selectedBorderStyle' => $this->selectedBorderStyle,

            'displayShadow' => $this->displayShadow,
            'coloredShadow' => $this->coloredShadow,
            'shadowDirection' => $this->shadowDirection,
            'shadowGradient' => $this->gradient,

            'roundStyle' => $this->roundStyle,
            'fontSize' => $this->fontSize,
        ));

        // If gradient is not set, set the foreground color to skin color
        if (!$this->gradient){
            $skin = Yii::app()->getComponent( "skin" );
            $color = GradientInfo::getLastColor( $skin->gradient );
            $options['style'] = array_key_exists('style', $options) ? $options['style'] : array();
            $options['style'] = StyleUtil::mergeStyles($options['style'], "color:$color" );
        }
        return ComponentUtil::mergeHtmlOptions( $options, $this->options );
    }

    /**
     * @return string the label for the button including any icon set.
     */
    public function getLabel(){
        return "<span class='{$this->iconClass}'></span>";
    }
}
