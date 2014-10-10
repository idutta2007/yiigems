<?php

/**
 * Widget to create embedded closable messages.
 * The Message widget allows you to create messages that can be displayed inside
 * your web page. A message widget can include any code that can be placed inside a
 * div element but typically contains text content.
 * 
 * <pre>
 * 
 * The DefaultSkin class defines the following scenario for Message widget.
 * 
 * info - used to display informational messages.
 * warning - used to display warning messages.
 * error - used to display error messages.
 * success - used to denote success in an operation.
 * failure - used to denote failure of an operation.
 * systemAlert - used to denote a system error.
 * formNote - used to display informational messages in a form.
 * 
 * Custom or derived skin can define additional scenario if required.
 * 
 * </pre>
 * 
 * Here is an example on how to create an error message:
 * 
 * <pre>
 * 
 * <?php $this->beginWidget("ext.yiigems.widgets.message.Message", array(
 *   'scenario' => 'error',
 * ));?>
 * <p>
 *  Failed to save information to database. Make sure you your database server is
 *  up and running. In case, the error persists please contact the system 
 *  administrator.
 * </p>
 * <?php $this->endWidget()?>
 * 
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.message
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.message.MessageDefaults");

class Message extends AppWidget {
    /**
     * @var string the title text for the message.
     */
    public $headerText;
    
    /**
     * @var string the icon to be displayed in front of the header text. 
     */
    public $headerIconClass;
    
    /**
     * @var string the message content.
     * There are two ways the content of message widget can be provided. One 
     * way is to set the content attribute and the second way is to include the
     * content between beginWidget and endWidget call.
     */
    public $content;
    
    /**
     * @var string the background gradient of the message. 
     */
    public $gradient;
    
    
    public $fontSize;
    
    /**
     * @var string the corner round style of the message widget. 
     */
    public $roundStyle;
    
    /**
     * @var boolean whether a shadow should be displayed for the message widget. 
     */
    public $displayShadow;
    
    /**
     * @var string the direction of shadow for the message widget. 
     */
    public $shadowDirection;
    
    /**
     * @var string whether the shadow should be colored. 
     */
    public $coloredShadow;
    
    /**
     * @var boolean whether the message widget allows closing with a  close button. 
     */
    public $allowClose;
    
    /**
     * @var array the HTML options for the container tag. 
     */
    public $containerOptions = array();
    
    /**
     * @var array the HTML options for the message header. 
     */
    public $headerOptions = array();
    
    /**
     * @var string the name of the skin class associated with this widget. 
     */
    public $skinClass = "MessageDefaults";
    
    /**
     * @var boolean flag indicating whether only the header should be displayed. 
     */
    public $bodyNull;
    
    /**
     * Sets up asset information for this widget.
     * @see AppWidget::setupAssetsInfo
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            "message.css",
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->gradient);
    }
    
    /**
     * @return array of widget prioprty names which are copied from skin class.
     */
    public function getCopiedFields(){
        return array( 
            "headerText",
            "gradient", "headerIconClass", 
            "fontSize", "roundStyle", 
            "displayShadow", "coloredShadow", "shadowDirection",
            "allowClose", "bodyNull"
        );
    }
    
    /**
     * @return array of widget prioprty names which are merged from skin class.
     */
    public function getMergedFields(){
        return array("headerOptions", "containerOptions");
    }
    
    /**
     * Initializes this widget and produces the opening tags. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "div", $this->getContainerOptions());
        if ($this->headerText){
            echo CHtml::openTag( "div", $this->getHeaderOptions());
            if ( $this->headerIconClass ){
                echo "<span class='$this->headerIconClass'></span>";
            }
            echo $this->headerText;
            echo CHtml::closeTag( "div");
        }
        if ($this->content && !$this->bodyNull) echo $this->content;
    }
    
    /**
     * @return array the HTML options for the container tag. 
     */
    private function getContainerOptions(){
        $options =  ComponentUtil::computeHtmlOptions(array(
            'id'=>$this->id,
            'class' => $this->bodyNull ? 'message nocontent' : 'message',
            'addClass' => $this->addClass,
            'bgGradient' => $this->gradient,
            'fgColor' => $this->gradient,
            'borderGradient' => $this->gradient,
            'fontSize' => $this->fontSize,
            'roundStyle' => $this->roundStyle,
            'displayShadow' => $this->displayShadow,
            'shadowDirection' => $this->shadowDirection,
            'coloredShadow' => $this->coloredShadow,
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->containerOptions);
    }
    
    /**
     * @return array the options for the header message. 
     */
    private function getHeaderOptions(){
        $headerOptions = $this->headerOptions;
        $headerOptions['class'] = "message_header";
        return $headerOptions;
    }
    
    
    /**
     * Produces the closing tag and regsiter necessary scripts. 
     */
    public function run(){
        if ( $this->allowClose ){
            $id = UniqId::get("close-");
            echo CHtml::openTag("span", array(
                'id'=>$id,
                'class'=>"close_btn"
            ));
            echo "x";
            echo CHtml::closeTag("span");
             Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
                $('#$id').click(function(ev){
                    $(this).parent().slideToggle(200);
                    ev.preventDefault();
                    return false;
                });
            ");
        }
        echo CHtml::closeTag("div");
    }
}

?>
