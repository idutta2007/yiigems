<?php

/**
 * Description of InputGroup
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.inputs
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.logictowers.com/yiigems/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.utils.RoundStyleUtil");
Yii::import("ext.yiigems.widgets.inputs.InputGroupUtil");
Yii::import("ext.yiigems.widgets.inputs.InputGroupDefaults");

class InputGroup extends AppWidget {
    /**
     * @var array HTML options for the container element.
     */
    public $groupOptions = array();
    
    /** 
     * HTML options for the input text field to be created. Note that this array
     * is only when inputContent is empty and a input text field is created.
     */
    public $inputOptions = array();
    
    public $leftContent;
    public $inputContent;
    public $rightContent;
    
    public $fontSize;
    public $roundStyle;
    
    public $skinClass = "InputGroupDefaults";
    
    protected function getCopiedFields() {
        return array( "fontSize", "roundStyle" );
    }
    
    protected function getMergedFields() {
        return array( "groupOptions", "inputOptions" );
    }
    
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("ipg-");
    }

    protected function setupAssetsInfo() {
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "inputGroup.css", dirname(__FILE__) . "/assets");
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
        
        $leftRoundStyle = RoundStyleUtil::getLeftRoundStyle($this->roundStyle);
        $rightRoundStyle = RoundStyleUtil::getRightRoundStyle($this->roundStyle);
        $this->leftContent = $this->createContent($this->leftContent, "prefix", $leftRoundStyle);
        $this->rightContent = $this->createContent($this->rightContent, "suffix", $rightRoundStyle);
        
        echo CHtml::openTag("div", $this->getGroupOptions());
        if ( $this->leftContent ) echo $this->leftContent;
        if ( $this->inputContent ) {
            echo $this->inputContent;
        }
        else {
            echo CHtml::tag( "input", InputGroupUtil::computeInputHtmlOptions(array(
                'hasLeftContent' => $this->leftContent,
                'hasRightContent' => $this->rightContent,
                'groupRoundStyle' => $this->roundStyle,
                'htmlOptions' => $this->inputOptions,
            )));
        }
        if ( $this->rightContent ) echo $this->rightContent;
        echo CHtml::closeTag("div");
    }
    
    public function createContent($content, $contentClass, $roundStyle){
        if (is_array($content) ){
            $type = $content['type'];
            unset($content['type']);
            
            if ( $type == 'icon' ){
                $iconClass = array_key_exists("iconClass", $content)? $content['iconClass'] : "icon-pencil";
                return "<span class='group-icon $contentClass $roundStyle $iconClass'></span>";
            }
            if ( $type == 'text' ){
                $text = array_key_exists('text', $content)? $content['text'] :"";
                $style = array_key_exists('style', $content)? $content['style'] : "border-color:#aaa";
                return "<span class='$contentClass $roundStyle' style=$style>$text</span>";
            }
            else if ( $type == 'label' || $type == 'coloredLabel' ){
                $content['addClass'] = $contentClass;
                $content['roundStyle'] = $roundStyle;
                if( !array_key_exists("scenario", $content)) $content['scenario'] = "inputGroup";
                return $this->widget("ext.yiigems.widgets.labels.ColoredLabel", $content, true );
            }
            else if ( $type == 'button' || $type == 'gradientButon' ){
                $content['addClass'] = $contentClass;
                $content['roundStyle'] = $roundStyle;
                if( !array_key_exists("displayShadow", $content)) $content['displayShadow'] = false;
                return $this->widget("ext.yiigems.widgets.buttons.GradientButton", $content, true );
            }
            else if ( $type == 'dropdown' || $type == 'dropdownButton' ){
                $content['addClass'] = $contentClass;
                $content['roundStyle'] = $roundStyle;
                if ($contentClass == "suffix") $content['popupAlignment'] = "right";
                if( !array_key_exists("popupRoundStyle", $content)) $content['popupRoundStyle'] = $this->roundStyle;
                if( !array_key_exists("displayShadow", $content)) $content['displayShadow'] = false;
                return $this->widget("ext.yiigems.widgets.buttons.DropdownButton", $content, true );
            }
            else if ( $type == 'chosen' ){
                $content['addClass'] = "$contentClass $roundStyle";
                return $this->widget("ext.yiigems.widgets.chosen.ChosenField", $content, true );
            }
            else if ( $type == 'iconButton' ){
                $content['addClass'] = $contentClass;
                $content['roundStyle'] = $roundStyle;
                if( !array_key_exists("displayShadow", $content)) $content['displayShadow'] = false;
                return $this->widget("ext.yiigems.widgets.buttons.IconButton", $content, true );
            }
            else if ( $type == 'widget' ){
                $widgetClass = $content['widgetClass'];
                unset($content['widgetClass']);
                return $this->widget($widgetClass, $content, true );
            }
        }
        return $content;
    }
    
    public function getGroupOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => $this->id,
            'class' => 'igroup',
            'addClass' => $this->addClass,
            'fontSize' => $this->fontSize,
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->groupOptions);
    }
}

?>
