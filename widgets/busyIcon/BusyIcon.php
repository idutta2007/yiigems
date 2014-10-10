<?php

/**
 * Widget to display an animated busy icon to the user.
 * The BusyIcon widget allows you create an animated icon to indicate progress
 * of some operation. After rendering the BusyIcon is hidden on the web page. In
 * order to show it or hide it from user, you need to call jquery toggle method
 * on the selector "#busyIconId", where busyIconId denotes the id of the 
 * widget element.
 * 
 * <pre>
 * 
 * $this->widget("ext.yiigems.widgets.busyIcon.BusyIcon", array(
 *       'id'=>"busyIcon",
 *       'busyMessage' => "Loading. Please wait ...",
 *       'styleName' => "arrows",
 *  ));
 * 
 * //You can show the BusyIcon in response to a button click as follows
 * 
 * $this->widget("ext.yiigems.widgets.buttons.GradientButton", array(
 *      'label' => 'Start/Stop',
 *      'buttonType'=>'action',
 *      'script'=>"
 *           $('#busyIcon').toggle();
 *       "
 * ));
 * 
 *</pre>
 * 
 * Available styles are:
 * 3Rotation, arrows, bar, bar2, bar3, barCircle, bert, bert2, bigCircleBall,
 * bigFlower, bigRoller, bigSnake, bouncingBall, circleBall, circleThickBox,
 * clock, dripCircle, expandingCircle, facebook, flower, hypnotize, indicator, 
 * indicatorBig, indicatorBig2, indicatorLite, kit, pacman, pik, pk, radar, 
 * refresh, roller, smallWait, snake, squares, squaresCircle, wheel, wheelThrobber.
 * 
 * Visit this {@link http://www.yiigems.com/index.php/site/page?view=demo.misc.busyIcons link} 
 * to see these icons in action.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.busyIcon
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class BusyIcon extends AppWidget {
    /** 
     * The HTML tag used to create the busyIcon. 
     * By default it is a div tag. 
     */
    public $tagName='div';
    
    /** 
     * The message displayed next to the animated icon.
     * Can be any valid HTML fragment.
     * @var string
     */
    public $busyMessage = "Please Wait ...";
    
    /** 
     * The style of the animated icon such as arrows, bar, barCircle etc.
     * For a complete list see above. Default value is 'arrows'.
     * @var string
     */
    public $styleName = "arrow";
    
    /**
     * The JQuery selector of a form element.
     * Specify this value as a form selector if the BusyIcon is to be displayed while
     * submitting a form.
     * @var stirng
     */
    public $formSelector = null;
    
    /**
     * The height of the BusyIcon in CSS units. 
     * Defaults to 30px. This is useful if the busy icon is to be aligned with some 
     * other element on the page.
     * @var string 
     */
    public $height = "30px";

    /**
     * @var bool specifies whether the busy icon is initially visible or not.
     */
    public $visible = false;
    
    /**
     * Sets up asset information for this widget. 
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo( "arrow.gif",
            dirname(__FILE__) . "/assets/busyIcon"
        );
    }
    
    /**
     * Sets the default values widget properties.
     * Calls the parent class method with the same name to initializes properties
     * of the widgets to defaults and then setup few other properties like widget
     * id.  
     */
    public function setMemberDefaults(){
        parent::setMemberDefaults();
        if ($this->id == null) $this->id = UniqId::get("busyIcon-");
    }

    /**
     * Initializes this widget by producing markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();

        $imageFileName = $this->getImageFileName();
        $imageUrl = $this->getAssetPublishPath("arrow.gif") . "/" . $imageFileName;

        $options = $this->visible? array('id'=>$this->id ) : array('id'=>$this->id, 'style'=>'display:none');
        echo CHtml::openTag($this->tagName, $options);
        echo CHtml::tag("img", array(
            'src'=>$imageUrl,
            'alt'=>"busyIcon",
            'style'=>"vertical-align:middle;margin-right:0.5em",
        ));
        echo $this->busyMessage;
        echo CHtml::closeTag($this->tagName);
    }

    /**
     * Ends this widget by registering any javascript required. 
     */
    public function run(){
        $this->registerFormSubmitScript();
    }

    /**
     * Given the name of the style, returns the image file name.
     * @return string 
     */
    public function getImageFileName(){
        return $this->styleName . ".gif";
    }

    /**
     * Registers a script to show the busy icon when a form is submitted.
     */
    public function registerFormSubmitScript(){
        if ( !$this->formSelector ) return;
        Yii::app()->clientScript->registerScript( $this->id, "
            $(document).ready(function(){
            $('$this->formSelector').bind( 'submit', function(ev){
                $('#$this->id').show();
            });
        ");
    }
}
?>
