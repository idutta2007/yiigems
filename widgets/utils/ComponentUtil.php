<?php

/**
 * Description of ComponentUtil
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import( "ext.yiigems.widgets.common.utils.StyleUtil");

class ComponentUtil {
    public static function getBackgroundClass($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        $colorAttribute = $selected ? 'selectedBgColor' : 'bgColor';
        $gradientAttribute = $selected ? 'selectedBgGradient' : 'bgGradient';
        if ( self::array_key_has_value( $colorAttribute, $attributes ) ){
            $bgColor = $attributes[$colorAttribute];
            if ( self::isYiiGemsColor( $bgColor)){
                $cssClass = "background_color_{$bgColor}";
            }
        }
        else if(self::array_key_has_value( $gradientAttribute, $attributes )){
            $cssClass = "background_{$attributes[$gradientAttribute]}";
        }
        return $cssClass;
    }

    public static function getBackgroundStyle($attributes){
        $style = array();
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        $colorAttribute = $selected ? 'selectedBgColor' : 'bgColor';
        if ( self::array_key_has_value( $colorAttribute, $attributes ) ){
            $bgColor = $attributes[$colorAttribute];
            if ( !self::isYiiGemsColor( $bgColor)){
                $style["background-color"] = $bgColor;
            }
        }
        return $style;
    }

    public static function getHoverBackgroundClass($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;
        if ( $selected ) return $cssClass;

        if ( self::array_key_has_value( 'hoverBgColor', $attributes )){
            $hoverBgColor = $attributes['hoverBgColor'];
            if ( self::isYiiGemsColor( $hoverBgColor)){
                $cssClass = "hover_background_color_{$hoverBgColor}";
            }
        }
        else if(self::array_key_has_value( 'hoverBgGradient', $attributes )){
            $cssClass = "hover_background_{$attributes['hoverBgGradient']}";
        }
        return $cssClass;
    }

    public static function getActiveBackgroundClass($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;
        if ( $selected ) return $cssClass;

        if ( self::array_key_has_value( 'activeBgColor', $attributes )){
            $activeBgColor = $attributes['activeBgColor'];
            if ( self::isYiiGemsColor( $activeBgColor)){
                $cssClass = "active_background_color_{$activeBgColor}";
            }
        }
        else if(self::array_key_has_value( 'activeBgGradient', $attributes )){
            $cssClass = "active_background_{$attributes['activeBgGradient']}";
        }
        return $cssClass;
    }

    public static function getColorClass($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        $attributeName = $selected ? "selectedFgColor" : "fgColor";
        if ( self::array_key_has_value( $attributeName, $attributes )){
            $fgColor = $attributes[$attributeName];
            if ( self::isYiiGemsColor($fgColor) ){
                $cssClass = "color_{$fgColor}";
            }
        }
        return $cssClass;
    }

    public static function getColorStyle($attributes){
        $style = array();
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        $colorAttribute = $selected ? 'selectedFgColor' : 'fgColor';
        if ( self::array_key_has_value( $colorAttribute, $attributes ) ){
            $fgColor = $attributes[$colorAttribute];
            if ( !self::isYiiGemsColor( $fgColor)){
                $style["color"] = $fgColor;
            }
        }
        return $style;
    }

    public static function getHoverColorClass($attributes){
        $cssClass = "";
        $style = array();
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        if ( $selected){
            if ( self::array_key_has_value( "selectedFgColor", $attributes ) ){
                $fgColor = $attributes["selectedFgColor"];
                if ( self::isYiiGemsColor($fgColor) ){
                    $cssClass = "hover_color_{$fgColor}";
                }
            }
        }
        else {
            if ( self::array_key_has_value( "hoverFgColor", $attributes )){
                $hoverFgColor = $attributes["hoverFgColor"];
                if ( self::isYiiGemsColor($hoverFgColor) ){
                    $cssClass = "hover_color_{$hoverFgColor}";
                }
            }
        }
        return $cssClass;
    }

    public static function getActiveColorClass($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        if ( $selected){
            // TODO
        }
        else {
            if ( self::array_key_has_value( "activeFgColor", $attributes )){
                $activeFgColor = $attributes["activeFgColor"];
                if ( self::isYiiGemsColor($activeFgColor) ){
                    $cssClass = "active_color_{$activeFgColor}";
                }
            }
        }
        return $cssClass;
    }

    public static function getBorderColorClasses($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        if ( $selected ){
            if ( self::array_key_has_value( "selectedBorderGradient", $attributes ) ){
                $selectedBorderGradient = $attributes['selectedBorderGradient'];
                if ( self::isYiiGemsColor($selectedBorderGradient) ){
                    $cssClass .= " border_{$selectedBorderGradient}";
                }
            }
        }
        else {
            $names = array( "borderGradient"=>"border", "hoverBorderGradient"=>"hover_border", "activeBorderGradient"=>"active_border");
            foreach( $names as $name=>$prefix){
                if ( self::array_key_has_value( $name, $attributes ) ){
                    $gradient = $attributes[$name];
                    if ( self::isYiiGemsColor($gradient) ){
                        $cssClass .= " {$prefix}_{$gradient}";
                    }
                }
            }
        }
        return $cssClass;
    }

    public static function getBorderStyleClasses($attributes){
        $cssClass = "";
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;

        if ( $selected ){
            if ( self::array_key_has_value( "selectedBorderStyle", $attributes ) ){
                $selectedBorderStyle = $attributes['selectedBorderStyle'];
                $cssClass .= " border_style_{$selectedBorderStyle}";
            }
        }
        else {
            $names = array( "borderStyle"=>"border_style", "hoverBorderStyle"=>"hover_border_style", "activeBorderStyle"=>"active_border_style");
            foreach( $names as $name=>$prefix){
                if ( self::array_key_has_value( $name, $attributes ) ){
                    $borderStyle = $attributes[$name];
                    $cssClass .= " {$prefix}_{$borderStyle}";
                }
            }
        }
        return $cssClass;
    }

    public static function getShadowClass($attributes){
        $cssClass = "";

        if ( self::array_key_has_value( 'displayShadow', $attributes )){
            if ( self::array_key_has_value( 'coloredShadow', $attributes )){
                if ( self::array_key_has_value( 'shadowDirection', $attributes ) && self::array_key_has_value( 'shadowGradient', $attributes )) {
                    $cssClass .= " shadow_{$attributes['shadowDirection']}_{$attributes['shadowGradient']}";
                }
            }
            else if(self::array_key_has_value( 'shadowDirection', $attributes )){
                $cssClass .= " shadow_{$attributes['shadowDirection']}";
            }
        }
        return $cssClass;
    }

    public static function array_key_has_value( $key, $attributes){
        return array_key_exists( $key, $attributes ) && $attributes[$key];
    }

    public static function computeHtmlOptions( $attributes ){
        // First compute the class
        $cssClass = array_key_exists( 'class', $attributes ) ? $attributes['class'] : "";
        $cssClass = array_key_exists( 'addClass', $attributes ) ? "{$attributes['addClass']}  {$cssClass}" : $cssClass;

        // If selected selected class is added
        $selected = array_key_exists( 'selected', $attributes ) ? $attributes['selected'] : false;
        if ( $selected ) $cssClass .= " selected";

        // Add classes related to background, color, border size, border style and shadow
        $cssClass .= " " . self::getBackgroundClass($attributes);
        $cssClass .= " " . self::getHoverBackgroundClass($attributes);
        $cssClass .= " " . self::getActiveBackgroundClass($attributes);

        $cssClass .= " " . self::getColorClass($attributes);
        $cssClass .= " " . self::getHoverColorClass($attributes);
        $cssClass .= " " . self::getActiveColorClass($attributes);

        $cssClass .= " " . self::getBorderColorClasses($attributes);
        $cssClass .= " " . self::getBorderStyleClasses($attributes);

        $cssClass .= " " . self::getShadowClass($attributes);

        // Font and round style
        if (array_key_exists( 'fontSize', $attributes ) ) $cssClass .= " {$attributes['fontSize']}";
        if (array_key_exists( 'roundStyle', $attributes ) ) $cssClass .= " {$attributes['roundStyle']}";

        // Get any style related to background or foreground
        $style = array_merge( self::getBackgroundStyle( $attributes ),  self::getColorStyle( $attributes ) );
        $style = StyleUtil::createStyle($style);


        // Return the HTML options
        $htmlOptions = array();
        if (array_key_exists( 'id', $attributes ) ) $htmlOptions['id'] = $attributes['id'];
        if ($cssClass) $htmlOptions['class'] = trim($cssClass);
        
        
        // Merge styles
        if (array_key_exists( 'style', $attributes ) ){
            $htmlOptions['style'] = $style ? StyleUtil::mergeStyles($style, $attributes['style']) : $attributes['style'];
        }
        else {
            if ($style) $htmlOptions['style'] = $style;
        }

        return $htmlOptions;
    }

    public static function mergeHtmlOptions( $options1, $options2 ){
        if ($options1 == null ) return $options2;
        if ($options2 == null ) return $options1;

        if (count($options1) == 0 ) return $options2;
        if (count($options2) == 0 ) return $options1;

        $options = array_merge( $options1, $options2 );

        if ( array_key_exists("class", $options1) && array_key_exists("class", $options2) ){
            $options['class'] = StyleUtil::mergeClasses( $options1['class'], $options2['class'] );
        }

        if ( array_key_exists("style", $options1) && array_key_exists("style", $options2) ){
            $options['style'] = StyleUtil::mergeStyles( $options1['style'], $options2['style'] );
        }

        return $options;
    }

    /**
     * Returns true if it is YiiGems recognized color. Otherwise returns false.
     * @param $color a color name such as aliveBlue1, oliveDrab4 etc.
     */
    public static function isYiiGemsColor( $color ){
        $firstChar = substr($color, 0, 1);
        $lastChar = substr($color, -1);
        if ( $firstChar == '#' ) return false;
        if ( is_numeric($lastChar) )  return true;

        // If last char is not numeric check the one before the last
        // For example color may be aliceBlue1h
        return is_numeric(substr($color, -2, 1));
    }
}
?>
















