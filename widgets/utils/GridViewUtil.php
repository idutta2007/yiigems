<?php
/**
 * An utility class to format and display content on GridView.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class GridViewUtil {
    public static $gridBtnStyle = "";
    public static $deleteBtnStyle = "";
    
    /**
     * Returns the string if it is not empty, otherwise returns the text "Not Set" wrapped in a span.
     * @param $str specifies the text to be displayed in a grid cell.
     * @return string the HTML content to be placed in a grid cell.
     */
    public static function displayString( $str ) {
        if ( $str ) {
            return $str;
        }
        return "<span class='null'>Not Set</span>";
    }

    /**
     * Truncates a string if it exceeds a specified length and returns the truncated string.
     * @param $str the string to be truncated.
     * @param $length the maximum length of th string.
     * @return string the truncated string.
     */
    public static function displayTruncatedString( $str, $length ) {
        if ( $str ) {
            return CText::truncate($str, $length );
        }
        return "<span class='null'>Not Set</span>";
    }

    /**
     * Formats a timestamp to "d-M-y h:i:s a" format if it is not null. If the timestamp is null, then the text
     * "Not Set" is returned wrapped in a span tag.
     * @param $timestamp
     * @return string returns the time in d-M-y h:i:s a format.
     */
    public static function displayTime( $timestamp ) {
        if ( $timestamp ) {
            return date( "d-M-y h:i:s a", $timestamp );
        }
        return "";
    }

    public static function displayDate( $timestamp ) {
        if ( $timestamp ) {
            return date( "d-M-y", $timestamp );
        }
        return "";
    }

    public static function displayEnabled( $enabled ) {
        return $enabled ? "Yes" : "No";
    }

    public static function displayBoolean( $value ) {
        return $value ? "Yes" : "No";
    }
    
    public static function getRecordLink($label, $id, $route="view"){
        return CHtml::link(CHtml::encode($label),array( $route,"id"=>$id));
    }
    
    public static function getFilterMarkup($model, $column, $width=null){
        $value="";
        if ( $model != null ){
            $value = $model->$column;
        }
        $name = get_class($model) . "[$column]";
        $style = $width ? "width:$width" : "";
        return "<input name=$name type='text' maxlength=128 style='$style' value='$value'/>";
    }
    
    public static function createViewButton($action='view', $viewVisibleExp=null) {
        return array(
                'label'=>"<span class='icon-eye-open'></span>",
                'url'=>'Yii::app()->controller->createUrl("' . $action .'",array("id"=>$data->primaryKey))',
                'options'=>array('class'=>'custView', 'title'=>'View'),
                'visible'=>$viewVisibleExp
        );
    }
    
    public static function createUpdateButton($action='update', $updateVisibleExp=null) {
        return array(
                'label'=>"<span class='icon-pencil'></span>",
                'url'=>'Yii::app()->controller->createUrl("' . $action .'",array("id"=>$data->primaryKey))',
                'options'=>array('class'=>'custUpdate', 'title'=>'Edit'),
                'visible'=>$updateVisibleExp
        );
    }
    
    public static function createDeleteButton($action='delete', $deleteVisibleExp=null) {
        return array(
                'label'=>"<span style='color:#900' class='icon-remove'></span>",
                'url'=>'Yii::app()->controller->createUrl("' . $action .'",array("id"=>$data->primaryKey))',
                'options'=>array('class'=>'custDelete', 'title'=>'Delete'),
                'visible'=>$deleteVisibleExp
        );
    }
    
    public static function createButtonColumn($allowDelete, $options=array()){
        if(!array_key_exists('viewAction', $options)) $options['viewAction'] = 'view';
        if(!array_key_exists('viewVisibleExp', $options)) $options['viewVisibleExp'] = null;
        
        if(!array_key_exists('updateAction', $options)) $options['updateAction'] = 'update';
        if(!array_key_exists('updateVisibleExp', $options)) $options['updateVisibleExp'] = null;
        
        if(!array_key_exists('deleteAction', $options)) $options['deleteAction'] = 'delete';
        if(!array_key_exists('deleteVisibleExp', $options)) $options['deleteVisibleExp'] = null;
        
        if(!array_key_exists('htmlOptions', $options)) $options['htmlOptions'] = array('style' => 'width:5em;text-align:center');
                
        $buttonTemplate = "{customView}{customUpdate}";
        $deleteBtn = "";
        if ($allowDelete) {
            $buttonTemplate = "{customView}{customUpdate}{customDelete}";
            $htmlOptions = array('style' => 'width:5em;text-align:center');
            $deleteBtn = GridViewUtil::createDeleteButton($options['deleteAction'], $options['deleteVisibleExp']);
        }
        return array(
            'class' => 'CButtonColumn',
            'template' => $buttonTemplate,
            'buttons' => array(
                'customView' => GridViewUtil::createViewButton($options['viewAction'], $options['viewVisibleExp']),
                'customUpdate' => GridViewUtil::createUpdateButton($options['updateAction'], $options['updateVisibleExp']),
                'customDelete' => $deleteBtn
             ),
            'htmlOptions' => $options['htmlOptions']
        );
    }
}
?>
