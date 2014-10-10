<?php

/**
 * DefaultSkin class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.skin
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class DefaultSkin {
    public $gradient = "glassyOliveDrab7";
    public $selectedGradient = "deepSkyBlue3";
    
    function __construct() {
    }
    
    public function init(){
    }

    public function setUISkin(){
        $this->setGradientButtonSkin();
        $this->setIconButtonSkin();
        $this->setDropdownButtonSkin();
        
        $this->setButtonBarSkin();
        $this->setButtonStackSkin();
        $this->setTitleHeaderSkin();
        $this->setTitleBarSkin();
        $this->setTitleBoxSkin();
        $this->setAppGridViewSkin();
        $this->setLeftSidebarMenuSkin();
        $this->setRightSidebarMenuSkin();
        $this->setJupiterDropdwonMenuSkin();
        $this->setNeptuneDropdownMenuSkin();
        $this->setProgressBarSkin();
        $this->setRibbonTextSkin();
        $this->setRibbonMenuSkin();
        $this->setFaqSkin();
        $this->setSpeechBubbleSkin();
        $this->setTransientMessageSkin();
    }
    
    public function setTransientMessageSkin(){
        Yii::import("ext.yiigems.widgets.message.TransientMessageDefaults");
        TransientMessageDefaults::$gradient = "fireBrick6";
    }

    public function setSpeechBubbleSkin(){
        Yii::import("ext.yiigems.widgets.text.SpeechBubbleDefaults");
        SpeechBubbleDefaults::$gradient = $this->gradient;
    }
    
    public function setGradientButtonSkin(){
        Yii::import("ext.yiigems.widgets.buttons.GradientButtonDefaults");
        GradientButtonDefaults::$gradient = $this->gradient;
        GradientButtonDefaults::$options = array();
    }
    
    public function setIconButtonSkin(){
        Yii::import("ext.yiigems.widgets.buttons.IconButtonDefaults");
        IconButtonDefaults::$gradient = $this->gradient;
    }
    
    public function setDropdownButtonSkin(){
        Yii::import("ext.yiigems.widgets.buttons.DropdownButtonDefaults");
        DropdownButtonDefaults::$gradient = $this->gradient;
        DropdownButtonDefaults::$options = array();
    }
    
    public function setButtonBarSkin(){
        Yii::import("ext.yiigems.widgets.buttonGroup.ButtonBarDefaults");
        ButtonBarDefaults::$gradient = $this->gradient;
        ButtonBarDefaults::$selectedGradient = $this->selectedGradient;
        ButtonBarDefaults::$roundStyle = "round";
    }
    
    public function setButtonStackSkin(){
        Yii::import("ext.yiigems.widgets.buttonGroup.ButtonStackDefaults");
        ButtonStackDefaults::$gradient = $this->gradient;
        ButtonStackDefaults::$selectedGradient = $this->selectedGradient;
    }
    
    public function setTitleHeaderSkin() {
        Yii::import("ext.yiigems.widgets.title.TitleHeaderDefaults");
        Yii::import("ext.yiigems.widgets.common.utils.GradientInfo");
        TitleHeaderDefaults::$titleColor = GradientInfo::getFirstColor($this->gradient);
        TitleHeaderDefaults::$scenarios = array(
            'menuHeader' => array(
                'options' => array('style' => 'margin-bottom:0.1em;text-align:center')
            ),
            'sectionHeader' => array(
                'fontSize' => 'font_size18',
                'options' => array('style' => 'font-weight:bold;border-bottom:1px dotted gray;margin-bottom:0.5em')
            ),
            'formSectionHeader' => array(
                'fontSize' => 'font_size18',
                'options' => array('style' => 'font-weight:bold;border-bottom:1px dotted gray;margin-bottom:0.5em')
            ),
            'pageHeader' => array(
                'fontSize' => 'font_size24',
                'options' => array('style' => 'border-bottom:0;font-weight:bold;text-align:center'),
            )
        );
    }
    
    public function setTitleBarSkin(){
        Yii::import("ext.yiigems.widgets.title.TitleBarDefaults");
        TitleBarDefaults::$gradient = $this->gradient;
    }
    
    public function setTitleBoxSkin(){
        Yii::import("ext.yiigems.widgets.titleBox.TitleBoxDefaults");
        TitleBoxDefaults::$headerGradient = $this->gradient;
        TitleBoxDefaults::$contentGradient = null;
    }
    
    public function setAppGridViewSkin(){
        Yii::import("ext.yiigems.widgets.yii.AppGridViewDefaults");
        AppGridViewDefaults::$headerGradient = $this->gradient;
    }
    
    public function setLeftSidebarMenuSkin(){
        Yii::import("ext.yiigems.widgets.sidebarMenu.LeftSidebarMenuDefaults");
        LeftSidebarMenuDefaults::$gradient = $this->gradient;
        LeftSidebarMenuDefaults::$rightIconClass = "icon-chevron-right pull-right";
        LeftSidebarMenuDefaults::$dividerColor = "#aaa";
    }
    
    public function setRightSidebarMenuSkin(){
        Yii::import("ext.yiigems.widgets.sidebarMenu.RightSidebarMenuDefaults");
        RightSidebarMenuDefaults::$gradient = $this->gradient;
        RightSidebarMenuDefaults::$leftIconClass = "icon-chevron-left pull-left";
        RightSidebarMenuDefaults::$dividerColor = "#aaa";
    }
    
    public function setJupiterDropdwonMenuSkin(){
        Yii::import("ext.yiigems.widgets.dropdown.JupiterDropdownMenuDefaults");
        JupiterDropdownMenuDefaults::$menuGradient = $this->gradient;
    }
    
    public function setNeptuneDropdownMenuSkin(){
        Yii::import("ext.yiigems.widgets.dropdown.NeptuneDropdownMenuDefaults");
        NeptuneDropdownMenuDefaults::$menuGradient = $this->gradient;
    }

    public function setProgressBarSkin() {
        Yii::import("ext.yiigems.widgets.progressBar.ProgressBarDefaults");
        ProgressBarDefaults::$containerGradient = "glassyGray6";
        ProgressBarDefaults::$barGradient = $this->gradient;
    }

    public function setRibbonTextSkin() {
        Yii::import("ext.yiigems.widgets.ribbon.RibbonTextDefaults");
        RibbonTextDefaults::$barGradient = $this->gradient;
    }

    public function setRibbonMenuSkin() {
        Yii::import("ext.yiigems.widgets.ribbon.RibbonMenuDefaults");
        RibbonMenuDefaults::$barGradient = $this->gradient;
    }

    public function setFaqSkin() {
        Yii::import("ext.yiigems.widgets.faq.FaqDefaults");
        FaqDefaults::$gradient = $this->gradient;
    }
}

?>
