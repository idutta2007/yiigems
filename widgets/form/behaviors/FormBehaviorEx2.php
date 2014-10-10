<?php

/**
 * Behavior for widgets created in Yiigems extension. 
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form.behaviors
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class FormBehaviorEx2 extends CBehavior {
    public function monthPicker($model, $column, $options=null){
        $options = $options? $options : $this->owner->computeElementOptions($model, $column, "monthPicker");
        
        $options['allowMonthSelection'] = true;
        $options['allowYearSelection'] = false;
        $options['format'] = array_key_exists("format", $options) ? $options['format'] : "{month}";
        $options['selectedValue'] = $model->$column;
        return Yii::app()->controller->widget( "ext.yiigems.widgets.inputs.MonthYearPicker", $options, true);
    }
    
    public function yearPicker($model, $column, $options=null){
        $options = $options? $options : $this->owner->computeElementOptions($model, $column, "yearPicker");
        
        $options['allowMonthSelection'] = false;
        $options['allowYearSelection'] = true;
        $options['format'] = "{year}";
        $options['selectedValue'] = $model->$column;
        return Yii::app()->controller->widget( "ext.yiigems.widgets.inputs.MonthYearPicker", $options, true);
    }
    
    public function monthYearPicker($model, $column, $options=null){
        $options = $options? $options : $this->owner->computeElementOptions($model, $column, "monthYearPicker");
        
        $options['allowMonthSelection'] = true;
        $options['allowYearSelection'] = true;
        $options['format'] = array_key_exists("format", $options) ? $options['format'] : "{month}, {year}";
        $options['selectedValue'] = $model->$column;
        return Yii::app()->controller->widget( "ext.yiigems.widgets.inputs.MonthYearPicker", $options, true);
    }
}

?>
