<?php

/**
 * An widget to create floating panes which are positioned relative to the browser window.
 * FloatingPanes are widgets which are positioned on the browser window at a fixed location. The position of the floating
 * pane can be specified by specifying any one or more of the attributes topOffset, bottomOffset, leftOffset, and
 * rightOffset in addition to height. For example, in order to create a floating pane which acts as a fixed header
 * of your web site, you will set topOffset, leftOffset, rightOffset and a height for the pane.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.panes
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");

class FloatingPane extends AppWidget {
    /**
     * @var string the id of the widget element.
     */
    public $id;

    /**
     * @var string Offset of the top of the element from the browser top side.
     */
    public $topOffset = null;

    /**
     * @var string Offset of the bottom of the element from the browser bottom side .
     */
    public $bottomOffset = null;

    /**
     * @var string Offset of the left of the element from the browser left side.
     */
    public $leftOffset = null;

    /**
     * @var string Offset of the right of the element from the browser right side.
     */
    public $rightOffset = null;

    /**
     * @var string the height of the floating pane in css units.
     */
    public $height = "20px";

    /**
     * @var array the options for the container element.
     */
    public $navOptions = array();

    /**
     * Sets uo asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
                "floatingPane.css", 
                dirname(__FILE__) . "/assets"
        );
    }

    /**
     * Sets the default values of its members.
     */
    protected function setMemberDefaults(){
        if (!$this->id) $this->id = UniqId::get("fp-");
    }

    /**
     * Initializes this widget by registering all assets and producing the opening tags.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "nav", $this->getNavOptions());
    }

    /**
     * @return array the HTML options for the container element.
     */
    private function getNavOptions(){
        $options = $this->navOptions;
        $options['id'] = $this->id;
        $options['class'] = "floatingPane";
        
        $style = "position:fixed;overflow:visible;";
        if ($this->height ) $style .= "height:$this->height;";
        if ($this->topOffset ) $style .= "top:$this->topOffset;";
        if ($this->bottomOffset ) $style .= "bottom:$this->bottomOffset;";
        if ($this->leftOffset ) $style .= "left:$this->leftOffset;";
        if ($this->rightOffset ) $style .= "right:$this->rightOffset;";
        
        // Merge styles from options
        if (array_key_exists( 'style', $this->navOptions) ){
            $style = StyleUtil::mergeStyles( $this->navOptions['style'], $style);
        }
        if ( $style ) $options['style'] = $style;
        
        return $options;
    }

    /**
     * Produces the closing tag for the floating pane.
     */
    public function run(){
        echo CHtml::closeTag( "nav" );
    }
}
?>
