<?php

/**
 * A tooltip based on JQuery UI tooltip
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.tooltips
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import( "ext.yiigems.widgets.tooltips.TooltipDefaults");

class Tooltip extends AppWidget {
    /**
     * @var string the content of the tooltip provided as a string.
     */
    public $content;

    /**
     * @var string a JQuery selector whose content is used to create the tooltip
     */
    public $contentSelector;

    /**
     * @var string specifies how the content of the tooltip is selected from the  $contentSelector element. The valid
     * values are text, html, innerHTML, OuterHTML.
     */
    public $contentSelectionMethod;

    /**
     * @var string the URL from which the content of the tooltip is retrieved.
     */
    public $contentUrl;

    /**
     * @var string JQuery selector for items which will trigger the display of the tooltip
     */
    public $items;

    /**
     * @var selector of the element relative to which the tooltip is displayed
     */
    public $target;

    /**
     * @var string tooltip locations
     */
    public $location;
    public $topPos;
    public $bottomPos;
    public $leftPos;
    public $rightPos;
    

    /**
     * @var string the name of the JQuery effect to show the tooltip
     */
    public $effectName;

    /**
     * @var integer the duration of the effect in milliseconds.
     */
    public $duration;

    /**
     * @var string the location of the tooltip used for position against the target element.
     */
    public $my;

    /**
     * @var string the the position on te target element against which positioning is done. Examples are same as in
     * JQuery positioning like "left top", "right bottom" etc.
     */
    public $at;

    public $skinClass = "TooltipDefaults";

    public function  setupAssetsInfo(){
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();
        $this->addAssetInfo( "tooltip.css", dirname(__FILE__) . "/assets/tooltip" );
    }

    public function getCopiedFields(){
        return array(
            "contentSelectionMethod", 
            "topPos", "bottomPos", "leftPos", "rightPos", "location", 
            "effectName", "duration"
        );
    }

    public function setMemberDefaults(){
        parent::setMemberDefaults();

        // If location is given update my and at
        if ( $this->location && !$this->my && !$this->at){
            $pos = "{$this->location}Pos";
            $pos = $this->$pos;

            $this->my = $this->my ? $this->my : $pos['my'];
            $this->at = $this->at ? $this->my : $pos['at'];
        }
    }

    public function init(){
        parent::init();
        $this->registerAssets();
    }

    public function run(){
        $tooltipClass = "$this->location brick-tooltip";
        $content = null;
        $openFunction = "\$.noop";
        $imageUrl = $this->getAssetPublishPath("tooltip.css") . "/wheelThrobber.gif";

        if ( $this->content ){
            $content = '"' . $this->content . '"';
        }
        else if ( $this->contentSelector ){
            if ($this->contentSelectionMethod == "innerHTML,"){
                $content = "\$('$this->contentSelector').innerHTML";
            }
            else if ($this->contentSelectionMethod == "outerHTML"){
                $content = "\$('$this->contentSelector').outerHTML";
            }
            else if ($this->contentSelectionMethod == "text"){
                $content = "\$('$this->contentSelector').text()";
            }
            else if ($this->contentSelectionMethod == "html"){
                $content = "\$('$this->contentSelector').html()";
            }
            else {
                $content = "\$('$this->contentSelector').innerHTML";
            }
        }
        else if ($this->contentUrl ){
            $content = "function(callback){
                var img = $('<img>').attr( 'src', '$imageUrl').css({position:'absolute'});
                img.insertAfter('$this->items');
                $.get('$this->contentUrl', function(data){
                    img.remove();
                    callback(data);
                });
            }";
        }

       $script = "
          \$('$this->target').tooltip({
             tooltipClass: '$tooltipClass',
             content: $content,
             open: $openFunction,
             items: '$this->items',
             show: {  effect: '$this->effectName', duration: $this->duration},
             position: {
                 my: '$this->my',
                 at: '$this->at',
                 of: '$this->target',
                 collision: 'none none'
             }
         });
        ";
        Yii::app()->clientScript->registerScript( UniqId::get("scr-"), $script );
    }
}
