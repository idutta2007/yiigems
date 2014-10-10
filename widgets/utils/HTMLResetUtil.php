<?php

/**
 * Description of HTMLResetUtil
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class HTMLResetUtil {
    public static function registerCssReset($fileName="html5_reset_reset.css"){
        $assetDir = dirname(__FILE__) . "/../common/assets/common/html5";
        $publishPath = Yii::app()->getAssetManager()->publish($assetDir);
        
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($publishPath . "/" . $fileName);
    }
}

?>
