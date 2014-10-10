<?php

/**
 * An widget to select time of the day.
 * The TimePicker widget is based on JQuery UI timePicker plugin which allows you to pick a time of the day. Using this
 * widget is fairly easy. The TimePicker widget also allows you few configuration whereby you can restrict it to select
 * only an hour of the day or a duration in minutes.
 *
 * <pre>
 *
 * $this->widget("ext.yiigems.widgets.timePicker.TimePicker", array(
 *   'name'=>"timeOfDay",
 * ));
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.timePicker
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class TimePicker extends AppWidget {
    /**
     * @var string the id of the widget container element.
     */
    public $id;

    /**
     * @var string the name of the element.
     * This may be required for form binding.
     */
    public $name;

    /**
     * @var string current value of time in the widget.
     */
    public $value;

    /**
     * @var array HTML options for the text displayed by this widget.
     */
    public $htmlOptions = array(); 
    
    /** The options passed to JQuery plugin */
    public $pluginOptions = array(
        'showPeriod' => true
    );

    /**
     * Sets up all asset information
     */
    protected function setupAssetsInfo() {
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();

        $this->assetsInfo[] = array(
            'name' => "jquery.ui.timepicker.css",
            'assetDir' => dirname(__FILE__) . "/assets"
        );
        
        $this->assetsInfo[] = array(
            'name' => "jquery.ui.timepicker.js",
            'assetDir' => dirname(__FILE__) . "/assets"
        );
    }

    /**
     * set properties values to defaults.
     */
    protected function setMemberDefaults(){
        if (!isset($this->id)) {
            $this->id = UniqId::get("tp-");
        }
    }

    /**
     * registers all assets and produces the tags for the input element.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::tag( "input", $this->computeInputOptions() );
    }

    public function computeInputOptions(){
        $options = array(
            'id'=>$this->id,
            'class'=>$this->addClass,
            'type'=>'text',
            'size'=>7,
            'name'=>$this->name,
            'value'=>$this->value,
        );
        return ComponentUtil::mergeHtmlOptions( $options, $this->htmlOptions );
    }

    /**
     * Registers appropriate javascript to create time picker.
     */
    public function run(){
        $json = count($this->pluginOptions) ? json_encode( $this->pluginOptions ) : "";
        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            $('#$this->id').timepicker($json);
        ");
    }
}

?>
