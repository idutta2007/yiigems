<?php
/**
 * An wrapper widget around JQuery plugin Quicksand.
 * The QuickSand widget allows filtering a list of HTML elements based on the name of the group to which the element
 * belongs. You can add content to a QuickSand widget by placing the content between {@link QuickSand::startItem startItem}
 * {@link QuickSand::endItem endItem} calls. For adding images and other widgets, QuickSand provides convenient methods
 * named {@link QuickSand::addImageLink addImageLink} and {@link QuickSand::addWidget addWidget}.
 * When you add an item to the QuickSand widget, you must also specify the group name to which the item belongs.
 *
 * When you create a QuickSand widget you must also create a set of trigger elements which causes the widget to filter
 * its contents. The triggering elements can be a set of HTML links, buttons or even another widget. When you create the
 * QuickSand widget, the filterMap property should be specified by mapping the id of the triggering elements to group
 * names.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.quicksand
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class QuickSand extends AppWidget {
    /**
     * @var array maps an element selector to a group name.
     * The widget will display the items belonging to the group when the element is clicked.
     */
    public $filterMap = array();

    /**
     * @var array the HTML options for the container element.
     */
    public $containerOptions = array();

    /**
     * Sets up asset information for the widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
            "js/jquery.easing.1.3.js",
            $this->getCommonAssetDir()
        );
        
        $this->addAssetInfo(
            array("quicksand.css", "quicksand.js"),
            dirname(__FILE__) . "/assets"
        );
    }

    /**
     * Sets the default values for the properties.
     */
    public function setMemberDefaults() {
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("qs-");
    }

    /**
     * Initializes this widget by registering assets and producing markups.
     */
    public function init() {
        parent::init();
        $this->registerAssets();
        
        // source list
        echo CHtml::openTag( "div", $this->getContainerOptions());
        echo CHtml::openTag( "ul", $this->getListOptions());
    }

    /**
     * @return array the HTML options for the container element.
     */
    private function getContainerOptions(){
        return array_merge( array(
            'class'=>'quicksand',
            'id'=>$this->id
        ), $this->containerOptions);
    }
    
    public function getListOptions() {
        return array();
    }
    
    public function startItem( $groupName){
        echo CHtml::openTag("li", array(
            'data-id'=>  UniqId::get("id-"),
            'data-group'=>$groupName,
        ));
    }
    
    public function endItem(){
        echo CHtml::closeTag("li");
    }
    
    public function addWidget( $groupName, $class, $options ){
        $this->startItem($groupName);
        Yii::app()->controller->widget($class, $options);
        $this->endItem();
    }
    
    public function addImageLink( $groupName, $image ){
        $this->startItem($groupName);
        $label = $this->createImageTag($image);
        $targetUrl = array_key_exists('targetUrl', $image) ? $image['targetUrl'] : "javascript:void(0)";
        $anchorOptions = array_key_exists('anchorOptions', $image) ? $image['anchorOptions'] : array();
        echo CHtml::link( $label, $targetUrl, $anchorOptions );
        $this->endItem();
    }
    
    private function createImageTag($image) {
        $src = array_key_exists("src", $image) ? $image['src'] : "#";
        $alt = array_key_exists("alt", $image) ? $image['alt'] : "";
        $htmlOptions = array_key_exists("imageOptions", $image) ? $image['imageOptions'] : array();
        return CHtml::image($src, $alt, $htmlOptions);
    }

    public function run() {
        echo CHtml::closeTag( "ul");
        echo CHtml::closeTag( "div");
        
        $script = "
            var qs = $('#{$this->id}>ul');
            var data = qs.clone();
        ";
            
        foreach( $this->filterMap as $selector=>$groupName ){
            $groupItemSelector = "li";
            if ( $groupName != "all" ){
                $groupItemSelector = "li[data-group=$groupName]";
            }
            $script .= "
                $('$selector').click(function(ev){
                    var allItems = data.find( 'li' );
                    var groupItems = data.find( '$groupItemSelector' );
                    qs.quicksand(allItems, {
                        duration: 10,
                        easing: 'easeInOutQuad'
                    }).quicksand(groupItems, {
                        duration: 500,
                        adjustHeight: 'dynamic',
                        easing: 'easeInOutQuad'
                    });
                    ev.preventDefault();
                    return false;
                });
            ";
        }
        $script = "         (function(){{$script}})();";
        Yii::app()->getClientScript()->registerScript( $this->id, $script );
    }
}
?>
