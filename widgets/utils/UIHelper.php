<?php
/**
 * An utility class for laying out elements across the page.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class UIHelper {
    /**
     * Creates and returns the markup a div with the given height that clears to the left.
     * @param string $height the height of the div.
     * @return string the markup for the div with given height that clears to the left.
     */
    public static function clearLeft( $height="1px" ){
         return "<div style='clear:left;height:$height'></div>";
     }

    /**
     * Creates and returns the markup for a div with the given height that clears to the right.
     * @param string $height the height of the div.
     * @return string the markup for the div with given height that clears to the right.
     */
     public static function clearRight( $height="1px" ){
         return "<div style='clear:right;height:$height'></div>";
     }

    /**
     * Creates and returns the markup for a div with the given height that clears on both sides.
     * @param string $height the height of the div.
     * @return string the markup for the div with given height that clears to both side.
     */
     public static function clearBoth( $height="1px" ){
         return "<div style='clear:both;height:$height'></div>";
     }

    /**
     * Creates a vertical strut of given height.  The height must be specified in pixel units.
     * @param string $height  the height of the strut in pixel units such as "10px".
     * @return string the markup for the vertical strut.
     */
    public static function verticalStrut( $height="10px"){
         return "<div style='height:$height'></div>";
     }

    /**
     * Creates and returns the markup for a horizontal strut of given width and height.
     * @param string $height  the height of the strut in CSS units.
     * @return string the markup for the horizontal strut.
     */
     public static function horizontalStrut( $width="10px", $height="10px"){
         return "<div style='display:inline-block;width:$width;height:$height'></div>";
     }

     public static function hr($hrStyle="margin:5px 0px;border:1px solid gray"){
         return "<div class='horzRule' style='$hrStyle'></div>";
     }

     public static function displayTime( $timestamp ){
         if ( $timestamp ){
             return date( "d-M-y h:i:s a", $timestamp );
         }
         return "";
     }

     public static function displayDate( $timestamp ){
         if ( $timestamp ){
             return date( "d-M-y", $timestamp );
         }
         return "";
     }

     public static function isValidImage($data) {
         $im = imagecreatefromstring($data);
         $valid = ($im !== false );
         imagedestroy($im);
         return $valid;
     }

     public static function outputResizedImage( $data, $toWidth, $toHeight, $honor="max"){
         // Get the size of the original image
         $tmpImage = imagecreatefromstring($data);
         $width = imagesx($tmpImage);
         $height = imagesy($tmpImage);

         // Compute scaling factors
         $xscale=$width/$toWidth;
         $yscale=$height/$toHeight;

         // compute the new size of the image
         if ( $honor == "width" )  $yscale = $xscale;
         if ( $honor == "height" ) $xscale = $yscale;
         if ( $honor == "max" ) $xscale = $yscale = max($xscale, $yscale);
         if ( $honor == "min" ) $xscale = $yscale = min($xscale, $yscale);
         
         $new_width = round($width * (1/$xscale));
         $new_height = round($height * (1/$yscale));

         // create the image to be returned
         $image = imagecreatetruecolor($new_width, $new_height);

         // Copy from the original with resampling so that it resizes
         imagecopyresampled($image, $tmpImage, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
         
         // send out to browser
         ob_clean();
         header('Content-type: image/png');
         imagepng($image);
         
         imagedestroy($tmpImage);
         imagedestroy($image);
     }

     public static function outputImage($data) {
        // Get the size of the original image
        $image = imagecreatefromstring($data);

        ob_clean();
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

     public static function image_tag( $path, $alt="picture", $style="" ){
         $imageUrl = Yii::app()->baseUrl . $path;
         return "<img src='$imageUrl' alt='$alt' style='$style'/>";
     }

     public static function focus( $selector ){
        Yii::app()->clientScript->registerScript( $selector, "$('$selector').focus();");
     }
}
?>
