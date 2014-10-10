<?php

/**
 * Description of InputGroupUtil
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.inputs
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */
class InputGroupUtil {
    /** 
     * Computes the HTML options for the input element in the InputGroup based
     * on $options. Note that $options must have all the 4 attributes accessed 
     * in this method.
     * @param type $options
     * @return type
     */
    public static function computeInputHtmlOptions($options){
        $hasLeftContent = $options['hasLeftContent'];
        $hasRightContent = $options['hasRightContent'];
        $groupRoundStyle = $options['groupRoundStyle'];
        $htmlOptions = $options['htmlOptions'];
        
        if ( $hasLeftContent && $hasRightContent ){
            $options = array( 'class' => 'control');
            return ComponentUtil::mergeHtmlOptions($options, $htmlOptions);
        }
        else if ( $hasLeftContent && !$hasRightContent ){
            $rightRoundStyle = RoundStyleUtil::getRightRoundStyle($groupRoundStyle);
            $options = array( 'class' => "control $rightRoundStyle");
            return ComponentUtil::mergeHtmlOptions($options, $htmlOptions);
        }
        else if ( !$hasLeftContent && $hasRightContent ){
            $leftRoundStyle = RoundStyleUtil::getLeftRoundStyle($groupRoundStyle);
            $options = array( 'class' => "control $leftRoundStyle");
            return ComponentUtil::mergeHtmlOptions($options, $htmlOptions);
        }
        return $htmlOptions;
    }
}

?>
