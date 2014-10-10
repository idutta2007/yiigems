<?php
/**
 * ClueTip class file. This is deprecated. Use Tooltip class instead.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.tooltips
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class ClueTip extends AppWidget {
    public $linkId;
    public $linkContent = "Tip";
    public $contentInline = true;
    public $contentId;
    public $scriptId;
    public $href;
    public $title;
    public $ajaxUrl;
    
    // Clue tip options
    public $multiple = 0;
    public $width = 275;
    public $height = 'auto';
    public $cluezIndex = 97;
    public $positionBy = 'auto';
    public $topOffset = 15;
    public $leftOffset = 15;
    public $local = 1;
    public $hideLocal = 0;
    public $localPrefix = null;
    public $localIdPrefix = null;
    public $attribute = 'rel';
    public $titleAttribute = 'title';
    public $splitTitle = '';
    public $escapeTitle = 0;
    public $showTitle = 1;
    public $cluetipClass = 'jtip';
    public $hoverClass = '';
    public $waitImage = 1;
    public $cursor = 'pointer';
    public $arrows = 1;
    public $dropShadow = 1;
    public $dropShadowSteps = 6;
    public $sticky = 0;
    public $mouseOutClose = 0;
    public $delayedClose = 50;
    public $activation = 'hover';
    public $clickThrough = 1;
    public $tracking = 0;
    public $closePosition = 'title';
    public $closeText = 'Close';
    public $truncate = 0;
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->assetsInfo[] = array(
            'name' => "jquery.cluetip.css",
            'assetDir' => dirname(__FILE__) . "/assets/clueTip"
        );
        
        $this->assetsInfo[] = array(
            'name' => "jquery.cluetip.min.js",
            'assetDir' => dirname(__FILE__) . "/assets/clueTip"
        );
    }
    
    protected function setMemberDefaults(){
        $this->linkId = $this->linkId ? $this->linkId : UniqId::get("ctlnk");
        $this->contentId = $this->contentId ? $this->contentId : UniqId::get("ctcnt-");
        $this->href = "javascript:void(0)";
        
        $this->local = $this->ajaxUrl ? 0 : 1;
        $this->showTitle = $this->title ? 1 : 0;
        if ( $this->ajaxUrl) $this->contentInline = 0;
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "a", array(
            'id'=>$this->linkId,
            'href'=>$this->href,
            'title'=>$this->title,
            'rel'=> $this->ajaxUrl ? $this->ajaxUrl : "#$this->contentId",
        ));
        echo $this->linkContent;
        echo CHtml::closeTag( "a");
        
        if ($this->contentInline) {
            echo CHtml::openTag("div", array(
                'id' => $this->contentId
            ));
        }
        
    }
    
    public function run(){
        if ($this->contentInline) {
            echo CHtml::closeTag("div");
        }
        
        $local = $this->local ? "local: true" : "local: false";
        
        $script = <<<EOT
        $(document).ready(function(){
           $("#$this->linkId").cluetip({
               width: $this->width,
               height: '$this->height',
               positionBy: '$this->positionBy',
               topOffset: $this->topOffset,
               leftOffset: $this->leftOffset,
               activation: '$this->activation',
               showTitle: $this->showTitle,
               dropShadow: $this->dropShadow,
               dropShadowSteps: $this->dropShadowSteps,
               sticky: $this->sticky,
               closePosition: '$this->closePosition',
               closeText: '$this->closeText',
               local: $this->local,
               cursor: '$this->cursor',
               cluetipClass: '$this->cluetipClass',
           });
        });
EOT;
        $this->scriptId = $this->scriptId ? $this->scriptId : UniqId::get("src-");
        Yii::app()->getClientScript()->registerScript( $this->scriptId, $script );
    }
}

?>
