<?php

/**
 * A scroll pane that remembers the position of the scroll bar between page reloads.
 *
 * SmartScrollPane widget remembers the position of the scroll bar between page loads so that user do not have to scroll
 * to the same position every time. This can be useful for web pages that displays a scrollable list of items on the
 * left or right and user can see detail of an item by clicking on that item. The page loaded after clicking on the item
 * still displays the scrollable list on left ior right and puts the scroll bar where it used to be.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.panes
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class SmartScrollPane extends AppWidget {
    /**
     * @var string the id of the SmartScrollPane assigned automatically if not set.
     */
    public $id = "smartScroll";

    /**
     * @var string width of the scroll pane in css units.
     */
    public $width = "240px";

    /**
     * @var string height of the scroll pane in css units.
     */
    public $height = "350px";

    /**
     * @var array the HTML options for the container element.
     */
    public $divOptions = array();

    /**
     * Sets up asset information for the widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
            array("js/jquery.cookie.js" ),
            $this->getCommonAssetDir()
        );
        $this->addAssetInfo(
            "smartScrollPane.css",
            dirname(__FILE__) . "/assets"
        );
    }

    /**
     * Initializes this widget by registering assets and generating opening tags.
     */
    public function init(){
        parent::init();
        $this->registerAssets();

        echo CHtml::openTag( "div", $this->getDivOptions());
    }

    /**
     * @return array the HTML options for the container element.
     */
    private function getDivOptions(){
        $options = $this->divOptions ? $this->divOptions : array();
        $options['id'] = $this->id ? $this->id : UniqId::get("sscr-");
        $options['class'] = "smartScrollPane";

        $style = "overflow:scroll;";
        if ($this->width ) $style .= "width:$this->width;";
        if ($this->height ) $style .= "height:$this->height;";
        
        if (array_key_exists("style", $options)){
            $options['style'] = StyleUtil::mergeStyles($style, $options['style']);
        }
        else {
            $options['style'] = $style;
        }
        return $options;
    }

    /**
     * Generates the closing tag of the scroll pane and registers javascripts.
     */
    public function run(){
        echo CHtml::closeTag( "div" );
        $this->registerScript();
    }

    /**
     * Registers javascripts for beforeunload and load events to restore snd remember scroll positions.
     */
    private function registerScript(){
        Yii::app()->clientScript->registerScript(UniqId::get("scr-", true), "
            $(window).bind('beforeunload', function(e){
                var scrollTop = $('#$this->id').scrollTop();
                $.cookie( '$this->id', scrollTop, {expires: 7, path: '/'} );
            });

            $(window).bind('load', function(){
                var top = $.cookie('$this->id');
                if ( top != undefined ){
                    $('#$this->id').scrollTop(top);
                }
            });
        ");
    }
}

?>
