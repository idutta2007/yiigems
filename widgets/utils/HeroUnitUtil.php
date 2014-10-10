<?php

/**
 * Utility class to create a HeoUnit.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class HeroUnitUtil {
    /**
     * Marks the beginning of the hero unit content.
     * @param $title the title of the HeroUnit.
     */
    public static function start($title){
        $con = Yii::app()->controller;
        $con->beginWidget('ext.yiigems.widgets.heroUnit.HeroUnit', array(
            'title' => $title
        ));
    }

    /**
     *  Marks the end of the hero unit content.
     */
    public static function end(){
        $con = Yii::app()->controller;
        $con->endWidget();
    }
}

?>
