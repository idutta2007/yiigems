<?php

/**
 * StarBurst class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.starburst
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");

class StarBurst extends AppWidget {
    public $size = "3em";
    public $margin = "2em";
    public $fontSize = "font_size20";
    public $numberOfAngles = 8;
    public $background = "#09f";
    public $hoverBackground = "#009";
    public $color = "white";
    public $hoverColor = "yellow";
    
    public $starRotation = -22.5;
    public $hoverRotation = -45;
    
    public $target = "site/index";
    
    public $text = "No<br>Text";
    public $nTextLines= 2;
    private $textLineHeight= 1.2; // in em unit
    
    private $options = array();
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
            "starburst.css",
            dirname(__FILE__) . "/assets"
        );
    }
    
    protected function getCopiedFields(){
        return array();
    }
    
    protected function getMergedFields(){
        return array();
    }
    
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("sb-");
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
        $this->addCss();
        
        
        echo CHtml::openTag("a", $this->getAnchorOptions());
        
        $nspans = ($this->numberOfAngles / 4) - 1;
        for ($i = 0; $i < $nspans; $i++ ) {
            echo CHtml::openTag("span", $this->getSquareOptions());
        }
        echo CHtml::openTag("span", $this->getAnchorTextOptions());
        echo $this->text;
        echo CHtml::closeTag("span");
        
        for ($i = 0; $i < $nspans; $i++ ) echo CHtml::closeTag("span");
        echo CHtml::closeTag("a");
    }
    
    public function getAnchorOptions() {
        $class = "starburst";
        if ($this->fontSize) $class .= " $this->fontSize";
        $style = StyleUtil::createStyle(array(
            'width'=>$this->size,
            'height'=>$this->size,
            'margin'=>$this->margin,
        ));
        return array(
            'id'=>$this->id,
            'class'=>$class,
            'style'=>$style,
            'href'=>Yii::app()->controller->createUrl($this->target)
        );
    }
    
    public function getSquareOptions() {
        $class = "square";
        $style = StyleUtil::createStyle(array(
            'width'=>$this->size,
            'height'=>$this->size,
        ));
        return array(
            'class'=>$class,
            'style'=>$style
        );
    }
    
    public function getAnchorTextOptions() {
        $height = $this->textLineHeight * $this->nTextLines . "em";
        $marginTop = ($this->textLineHeight * $this->nTextLines)/2 . "em";
        $style = StyleUtil::createStyle(array(
            'height'=>  $height,
            'top'=> "50%",
            'margin-top'=> "-$marginTop"
        ));
        return array(
            'class'=>'anchorText',
            'style'=>$style
        );
    }
    
    public function addCss(){
        $rotation = $this->computeSquareRotation();
        $style = "
            #$this->id {
                background: $this->background;
                color: $this->color;
                -webkit-transform:rotate({$this->starRotation}deg);
                -moz-transform:rotate({$this->starRotation}deg);
                rotation:{$this->starRotation}deg;
            }
                
            #$this->id span.square{
                background: $this->background;
                -webkit-transform:rotate({$rotation}deg);
                -moz-transform:rotate({$rotation}deg);
                rotation:{$rotation}deg;
            }
             
            #$this->id:hover {
                background: $this->hoverBackground;
                color: $this->hoverColor;
                -webkit-transform:rotate({$this->hoverRotation}deg);
                -moz-transform:rotate({$this->hoverRotation}deg);
                rotation:{$this->hoverRotation}deg;
            }
             
            #$this->id:hover,  #$this->id:hover span.square {
                background: $this->hoverBackground;
            }
                        
            #$this->id:hover span.anchorText {
                 text-shadow: 0px 0px 1em $this->hoverColor;
            }
        ";
        Yii::app()->clientScript->registerCss(UniqId::get( "css-"), $style );
    }
    
    public function computeSquareRotation(){
        return 360 / $this->numberOfAngles;
    }
    
    
    public function run(){
    }
}

?>
