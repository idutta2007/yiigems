<?php

/**
 * An widget to create a FAQ page.
 * 
 * The Faq widget allows you to create an FAQ page without writing any javascript
 * or CSS code. Faq Widget does this by generating links to expand and collapse 
 * your answer sections. So as a developer you need to focus only on the contents
 * and can keep your FAQ page neat and tidy.
 * 
 * <pre>
 * 
 * <?php $this->beginWidget("ext.yiigems.widgets.faq.Faq", array(
 *  'style'=>'bar',
 *  'roundStyle'=>'round',
 *));?>
 * <div class="question">This is question number 1</div>
 *   <div class="answer">
 *       <p>
 *         This is answer 1.
 *       </p>
 *   </div>
 *   
 *    <div class="question">This is question number 2</div>
 *   <div class="answer">
 *       <p>
 *         This is answer 2.
 *       </p>
 *   </div>
 *   
 *   <div class="question">This is question number 3</div>
 *   <div class="answer">
 *       <p>
 *           This is answer 3.
 *       </p>
 *   </div>
 *   
 *   <div class="question">This is question number 4</div>
 *   <div class="answer">
 *       <p>
 *          This is answer 4.
 *       </p>
 *   </div>
 *   
 *   <div class="question">This is question number 5</div>
 *   <div class="answer">
 *       <p>
 *          This is answer 5.
 *       </p>
 *   </div>
 * <?php $this->endWidget()?>
 * 
 * </pre>
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.faq
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.faq.FaqDefaults");

class Faq extends AppWidget {
    /**
     * @var string Specifies the style of the Faq Widget.
     * At present only two styles are supported - bar style and the basic style.
     * The bar style displays the questions in title bars which can be clicked
     * to collapse the answer section. The basic style is similar except that it
     * does not allow you to specify a background for the question. 
     */
    public $style;
    
    /**
     * @var string The gradient to be used for the answer. 
     */
    public $gradient;
    
    /**
     * @var string Specifies the round style of the question section. 
     */
    public $roundStyle;
    
    /**
     * @var boolean Specifies whether shadow should be displayed for the bars. 
     */
    public $displayShadow;
    
    /**
     * @var string specifies the direction of the shadow for bar style. 
     */
    public $shadowDirection;
    
    /**
     * @var string Specifies the icon to be used when answer is collapsed. 
     */
    public $expandIconClass;
    
    /**
     * @var string Specifies the icon to be used when answer section is expanded. 
     */
    public $collapseIconClass;
    
    /**
     * @var string The skin class for this widget. 
     */
    public $skinClass = "FaqDefaults";
    
    /**
     * Sets up asset information for this widget.
     * @see AppWidget::setupAssetsInfo
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            array( "$this->style.css", "faq.js"),
            dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->gradient);
    }
    
    public function getCopiedFields() {
        return array(
            "style", "gradient", "roundStyle",
            "displayShadow", "shadowDirection",
            "expandIconClass", "collapseIconClass"
        );
    }
    
    /**
     * Sets the values of widget properties to default values.
     * @see AppWidget::setMemberDefaults
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("faq-");
    }
    
    /**
     * Initializes this widget.
     * @see CWidget::init
     */
    public function init() {
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "div", array(
            'id'=>$this->id,
            'class'=> "faq-" . $this->style,
        ));
    }
    
    /**
     * Renders the closing tag for this widget and registers javascripts.
     * @see CWidget::init
     */
    public function run() {
        $class = "";
        if ($this->style != "basic") {
            if ($this->gradient) {
                $class .= "background_$this->gradient color_$this->gradient";
                
            }
            if ($this->roundStyle) {
                $class .= " $this->roundStyle";
            }
            if ($this->displayShadow && $this->shadowDirection ) {
                $class .= " shadow_$this->shadowDirection";
            }
        }
        
        echo CHtml::closeTag("div");
        $script = "
            $('#$this->id').find('.question').addClass( '$class' );
            $('#$this->id').faq({
                 expandIconClass : '$this->expandIconClass',
                 collapseIconClass : '$this->collapseIconClass'
            });
         ";
        Yii::app()->getClientScript()->registerScript($this->id, $script);
    }
}

?>
