<?php

/**
 * SiteFooterDefaults class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.siteFooter
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class SiteFooterDefaults {
    public static $gradient;
    
    public static $options = array();
    public static $anchorOptions = array('style'=>'color:#007');
    public static $companyAnchorOptions = array('style'=>'color:#070');
    public static $copyrightTextOptions = array('style'=>'color:gray');
    
    public static $scenarios = array(
        'white'=>array(
            'anchorOptions'=>array('style'=>'color:#ccc'),
            'companyAnchorOptions'=>array('style'=>'color:#dd0'),
            'copyrightTextOptions'=>array('style'=>'color:#eee'),
        ),
        'gray'=>array(
            'anchorOptions'=>array('style'=>'color:#444'),
            'companyAnchorOptions'=>array('style'=>'color:#007;'),
            'copyrightTextOptions'=>array('style'=>'color:black'),
        ),
    );
    
    
}

?>
