<?php

/**
 * Description of RoundStyleUtil
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common.utils
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class RoundStyleUtil {
    public static function getLeftRoundStyle($rs){
        if ( !$rs ) return "";
        
        $map = array(
            "small_round" => "small_round_left",
            "small_round_left" => "small_round_left",
            "small_round_right" => "",
            
            "round" => "round_left",
            "round_left" => "round_left",
            "round_right" => "",
            
            "medium_round" => "medium_round_left",
            "medium_round_left" => "medium_round_left",
            "medium_round_right" => "",
            
            "big_round" => "big_round_left",
            "big_round_left" => "big_round_left",
            "big_round_right" => "",
            
            "round_2em" => "round_2em_left",
            "round_2em_left" => "round_2em_left",
            "round_2em_right" => "",
        );
        return array_key_exists($rs, $map) ? $map[$rs] : "";
    }
    
    public static function getRightRoundStyle($rs){
        if ( !$rs ) return "";
        
        $map = array(
            "small_round" => "small_round_right",
            "small_round_right" => "small_round_right",
            "small_round_left" => "",
            
            "round" => "round_right",
            "round_right" => "round_right",
            "round_left" => "",
            
            "medium_round" => "medium_round_right",
            "medium_round_right" => "medium_round_right",
            "medium_round_left" => "",
            
            "big_round" => "big_round_right",
            "big_round_right" => "big_round_right",
            "big_round_left" => "",
            
            "round_2em" => "round_2em_right",
            "round_2em_right" => "round_2em_right",
            "round_2em_left" => "",
        );
        return array_key_exists($rs, $map) ? $map[$rs] : "";
    }
    
    public static function getTopRoundStyle($rs){
        if ( !$rs ) return "";
        
        $map = array(
            "small_round" => "small_round_top",
            "small_round_left" => "small_round_top_left",
            "small_round_right" => "small_round_top_left",
            
            "round" => "round_top",
            "round_left" => "round_top_left",
            "round_right" => "round_top_right",
            
            "medium_round" => "medium_round_top",
            "medium_round_left" => "medium_round_top_left",
            "medium_round_right" => "medium_round_top_right",
            
            "big_round" => "big_round_top",
            "big_round_left" => "big_round_top_left",
            "big_round_right" => "big_round_top_right",
            
            "round_2em" => "round_2em_top_left",
            "round_2em_left" => "round_2em_top_left",
            "round_2em_right" => "round_2em_top_right",
        );
        return array_key_exists($rs, $map) ? $map[$rs] : "";
    }
    
    public static function getBottomRoundStyle($rs){
        if ( !$rs ) return "";
        
        $map = array(
            "small_round" => "small_round_bottom",
            "small_round_left" => "small_round_bottom_left",
            "small_round_right" => "small_round_bottom_left",
            
            "round" => "round_bottom",
            "round_left" => "round_bottom_left",
            "round_right" => "round_bottom_right",
            
            "medium_round" => "medium_round_bottom",
            "medium_round_left" => "medium_round_bottom_left",
            "medium_round_right" => "medium_round_bottom_right",
            
            "big_round" => "big_round_bottom_bottom",
            "big_round_left" => "big_round_bottom_left",
            "big_round_right" => "big_round_bottom_right",
            
            "round_2em" => "round_2em_bottom_left",
            "round_2em_left" => "round_2em_bottom_left",
            "round_2em_right" => "round_2em_bottom_right",
        );
        return array_key_exists($rs, $map) ? $map[$rs] : "";
    }
}

?>
