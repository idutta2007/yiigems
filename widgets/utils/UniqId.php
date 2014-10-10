<?php
/**
 * HighlightUtil is an untilty class to make it convenient to use Highlighter widget.
 *
 * HighlightUtil provides convenient methiods for syntax highlighing PHP and HTML
 * code.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class UniqId {
    private static $last;

    public static function get($prefix){
        $id = str_replace(".", "",  uniqid($prefix, true) );
        while( $id === self::$last ){
            $id = str_replace(".", "",  uniqid($prefix, true) );
        }
        self::$last = $id;
        return $id;
    }

}
