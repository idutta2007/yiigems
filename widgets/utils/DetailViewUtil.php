<?php
/**
 * Description of DetailViewUtil
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */
class DetailViewUtil {
    public static function displayBoolean( $value ) {
        if ( $value  ) {
            return "<span style='color:#070'>Yes</span>";
        }
        return "<span style='color:#700'>No</span>";
    }

    public static function displayString( $str ) {
        if ( $str ) {
            return $str;
        }
        return "<span class='null'>Not Set</span>";
    }

    public static function displayTruncatedString( $str, $length ) {
        if ( $user ) {
            return CText::truncate($str, $length);
        }
        return "<span class='null'>Not Set</span>";
    }

    public static function displayTime( $timestamp ) {
        if ( $timestamp ) {
            return date( "d-M-y h:i:s a", $timestamp );
        }
        return "<span class='null'>Not Set</span>";
    }

    public static function displayDate( $timestamp ) {
        if ( $timestamp ) {
            return date( "d-M-y", $timestamp );
        }
        return "<span class='null'>Not Set</span>";
    }

    public static function displayMySqlDate( $dateStr ) {
        if ( $dateStr ) {
            return date("d-M-Y", strtotime($dateStr));
        }
        return "<span class='null'>Not Set</span>";
    }

    public static function displayEnabled( $enabled ) {
        return $enabled ? "Yes" : "No";
    }

    public static function displayImage( $image ) {
        if ( $image ) {
            return "<span style='color:#070'>Image Available</span>";
        }
        return "<span class='null'>Not Set</span>";
    }

    public static function getUserImageTag( $user, $width=50, $height=50 ) {
        if ($user->image_data == null ) {
            return "<span class='null'>Not Set</span>";
        }
        $url = Yii::app()->urlManager->createUrl( "/user/profile/thumbnail", array(
                'id'=>$user->id,
                'width'=>$width,
                'height'=>$height
        ));
        return "<img src='$url' alt='image'/>";
    }
    
    public static function displayDataUrlImage( $dataUrl ) {
        if ( $dataUrl ) return "<img src='$dataUrl' alt='image'/>";
        return "<span class='null'>Not Set</span>";
    }
    
    public static function emptyRow() {
        return array(
            'label' => '',
            'type' => 'raw',
            'value' => '&nbsp;'
        );
    }
    
    public static function headerRow( $label ) {
        $con = Yii::app()->controller;
        $title = $con->widget("ext.yiigems.widgets.title.TitleHeader", array(
            'titleText'=> $label,
            'options'=>array('style'=>'font-weight:bold;padding-top:0px;padding-bottom:0px'),
        ), true);
        
        return array(
            'label' => '',
            'type' => 'raw',
            'value' => $title
        );
    }
}
?>
