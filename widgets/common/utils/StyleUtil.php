<?php
/**
 * Description of StyleUtil
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */
class StyleUtil {
    public static function mergeClasses( $class1, $class2) {
        if ( $class1 == "" || $class1 == null ) return $class2;
        if ( $class2 == "" || $class2 == null ) return $class1;

        $class1Array = explode( " ", $class1);
        $class2Array = explode( " ", $class2);

        $classes = array_merge( $class1Array, $class2Array);
        $classes = array_unique($classes);
        return join( " ", $classes );
    }

    public static function mergeStyles( $style1, $style2) {
        if ( $style1 == "" || $style1 == null ) return $style2;
        if ( $style2 == "" || $style2 == null ) return $style1;

        $style1Array = explode( ";", $style1);
        $style2Array = explode( ";", $style2);

        $result = array();
        foreach( $style1Array as $style ) {
            $array = explode( ":", $style );
            if ( $array[0]) $result[trim($array[0])] = $array[1];
        }
        foreach( $style2Array as $style ) {
            $array = explode( ":", $style );
            if ( $array[0]) $result[trim($array[0])] = $array[1];
        }
        $style = "";
        foreach( $result as $key=>$value ) {
            $style .= $key . ":" . $value . ";";
        }
        return $style;
    }
    
    public static function createStyle( $map) {
        $result = "";
        foreach( $map as $key=>$value){
            if ( $value ){
                $result .= "$key:$value;";
            }
        }
        return $result;
    }
    
    public static function getScaledLength($length, $factor) {
        $number = substr($length, 0, -2);
        $number = doubleval($number) * $factor;
        $unit = substr($length, -2);
        return $number . $unit;
    }
    
    public static function getHalf($length) {
        $number = substr($length, 0, strlen($length) - 2);
        $number = $number / 2;
        $unit = substr($length, -2);
        return $number . $unit;
    }
    
    public static function getSum($length1, $length2) {
        $number1 = substr($length1, 0, strlen($length1) - 2);
        $number2 = substr($length2, 0, strlen($length2) - 2);
        $number = doubleval($number1) + doubleval($number2);
        $unit = substr($length1, -2);
        return $number . $unit;
    }
    
    public static function getDiff($length1, $length2) {
        $number1 = substr($length1, 0, strlen($length1) - 2);
        $number2 = substr($length2, 0, strlen($length2) - 2);
        $number = doubleval($number1) - doubleval($number2);
        $unit = substr($length1, -2);
        return $number . $unit;
    }
}

?>
