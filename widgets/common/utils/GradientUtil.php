<?php

/**
 * GradientUtil class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class GradientUtil {
    private static  function getBaseGradientName($gradientName){
        if (!$gradientName) return null;
        
        $number = substr($gradientName, -1);
        if ( is_numeric($number )){
            return $gradientName;
        }
        return substr($gradientName, 0, strlen($gradientName)-1);
    }
    
    public static  function getGradientDirName($gradientName){
        $number = substr($gradientName, -1);
        if ( is_numeric($number )){
            return substr($gradientName, 0, strlen($gradientName)-1);
        }
        return substr($gradientName, 0, strlen($gradientName)-2);
    }
    
    public static  function getGradientAssetDir($gradientName){
        $dirName = self::getGradientDirName($gradientName);
        if ( strpos($gradientName, "glassy") === 0 ){
            return Yii::getPathOfAlias("ext.yiigems") . "/widgets/common/assets/gradients/glassy/$dirName";
        }
        else if ( strpos($gradientName, "glossy") === 0 ){
            return Yii::getPathOfAlias("ext.yiigems") . "/widgets/common/assets/gradients/glossy/$dirName";
        }
        else if ( strpos($gradientName, "textured") === 0 ){
            return Yii::getPathOfAlias("ext.yiigems") . "/widgets/common/assets/gradients/texured/$dirName";
        }
        return Yii::getPathOfAlias("ext.yiigems") . "/widgets/common/assets/gradients/simple/$dirName";
    }
    
    public static function getCssFileForGradient($gradientName){
        $gradient = self::getBaseGradientName($gradientName);
        return "$gradient.css";
    }
    
    public static function getActiveGradient($gradient){
        if (!$gradient) return null;
        if ($gradient == "none") return null;
        $gradient = self::getBaseGradientName($gradient);
        return "{$gradient}a";
    }
    
    public static function getHoverGradient($gradient){
        if (!$gradient) return null;
        if ($gradient == "none") return null;
        $gradient = self::getBaseGradientName($gradient);
        return "{$gradient}h";
    }
    
    public static function getSelectedGradient($gradient){
        if (!$gradient) return null;
        if ($gradient == "none") return null;
        $gradient = self::getBaseGradientName($gradient);
        return "{$gradient}s";
    }
    
    public static  function getAquaShadowAssetDir($shadowName){
        $dirName = substr($shadowName, 0, strlen($shadowName)-1);
        return Yii::getPathOfAlias("ext.yiigems") . "/widgets/common/assets/shadows/aqua/$dirName";
    }
    
    public static function getCssFileForAquaShadow($shadowName){
        return "$shadowName.css";
    }
}
?>
