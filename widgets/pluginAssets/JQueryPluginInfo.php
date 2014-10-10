<?php

/**
 * Description of JQueryPluginInfo
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.pluginAssets
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */
class JQueryPluginInfo {
    public static $pluginInfos = array(
        array(
            'name' => 'timePicker',
            'assetDir' => '/assets/timePicker',
            'files' => array(
                'jquery.ui.timepicker.css',
                'jquery.ui.timepicker.js',
            ),
        ),
        array(
            'name' => 'chosen',
            'assetDir' => '/assets/chosen',
            'files' => array(
                'chosen.jquery.js',
                'chosen.css'
            ),
        ),
        array(
            'name' => 'cookie',
            'assetDir' => '/assets/cookie',
            'files' => array(
                'jquery.cookie.js'
            ),
        ),
        array(
            'name' => 'fancytree',
            'assetDir' => '/assets/fancytree/dist',
            'files' => array(
                'skin-lion/ui.fancytree.css',
                'jquery.fancytree.min.js',
                'src/jquery.fancytree.persist.js',
            ),
        ),
        array(
            'name' => 'maskedInput',
            'assetDir' => '/assets/maskedInput',
            'files' => array(
                'jquery.maskedInput.min.js'
            ),
        ),
        array(
            'name' => 'slickGrid',
            'assetDir' => '/assets/slickGrid',
            'files' => array(
                'slick.grid.css',
                'slick-default-theme.css',
                'lib/jquery.event.drag-2.2.js',
                'lib/jquery.event.drop-2.2.js',
                'slick.core.js',
                'slick.dataview.js',
                'slick.formatters.js',
                'slick.editors.js',
                'slick.grid.js',
                'slick.yiigems.editors.js',
            ),
        )
    );
    
    public static function getPluginInfo($name, $options=array()){
        foreach( self::$pluginInfos as $plugnInfo){
            if ( $plugnInfo['name'] === $name ){
                return $plugnInfo;
            }
        }
        return null;
    }
}

?>
