<?php
/**
 * Widget to create windows. In experimental state.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.windows
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */
 
Yii::import("ext.yiigems.widgets.windows.WindowDefaults");
Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.GradientInfo");

class Window extends AppWidget {
    public $containerTag;
    public $containerOptions = array();
    
    public $roundStyle;
    public $displayShadow;
    public $shadowDirection;
    public $coloredShadow;

    public $titleTag = "h3";
    public $titleOptions = array();
    public $titleFontSize = "font_size14";
    public $titleGradient;
    public $titleText;
    public $titleLeftIconClass;
    public $titleRightIconClass;
    
    public $dialogOptions = array(
        'autoOpen' => "false",
        'width' => 700,
        'height' => 400,
        'modal' => "true",
        
    );
    
    public $skinClass = "WindowDefaults";
    
    public function setupAssetsInfo() {
        JQuery::registerJQuery();
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "yiigems.window.js", dirname(__FILE__) . "/assets" );
        $this->addGradientAssets(array(
            $this->titleGradient
        ));
    }
    
    public function getCopiedFields() {
        return array(
            "containerTag",
            "roundStyle", "displayShadow", "shadowDirection", "coloredShadow",
            "titleTag", "titleFontSize", "titleGradient", "titleLeftIconClass", "titleRightIconClass",
        );
    }
    
    public function getMergedFields() {
        return array(
            "containerOptions", "titleOptions"
        );
    }
    
    public function setMemberDefaults() {
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("yw-");
    }
    
    public function init() {
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag($this->containerTag, $this->computeContainerOptions());
        
        $titleMarkup = Yii::app()->controller->widget("ext.yiigems.widgets.title.TitleBar", array(
            'containerTag' => $this->titleTag,
            'titleText' => $this->titleText,
            'fontSize' => $this->titleFontSize,
            'gradient' => $this->titleGradient,
            'leftIconClass' => $this->titleLeftIconClass,
            'rightIconClass' => $this->titleRightIconClass,
            'roundStyle' => "none",
            'displayShadow' => false,
            'options' => $this->titleOptions,
        ), true);
        $titleMarkup = str_replace( "'", '"', $titleMarkup);
        
       $borderColor = GradientInfo::getFirstColor( $this->titleGradient );
       $uiOptions = "";
       foreach( $this->dialogOptions as $key=>$value){
           $uiOptions .= "$key: $value,";
       }
       
       $script = "
        \$('#$this->id').dialog({
            titleMarkup: '$titleMarkup',
            borderColor: '$borderColor',
            $uiOptions
            dialogAddClass: 'border_$this->titleGradient round shadow_bottom_right'
        });";
       Yii::app()->clientScript->registerScript(uniqid::get("src-"), $script);
    }
    
    public function run() {
        echo CHtml::closeTag($this->containerTag );
    }
    
    function computeContainerOptions(){
        $cssClass = $this->addClass ? "$this->addClass bricks-window" : "bricks-window";
        $options = array();
        $options['id'] = $this->id;
        $options['class'] = $cssClass;
        return ComponentUtil::mergeHtmlOptions( $options, $this->containerOptions);
    }
}

?>
