<?php
/**
 * Description of AppLinkPager
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.yii
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */
class AppLinkPager extends CLinkPager {
    public $selectedAnchorCss = "background_skyBlue7";
    
    protected function createPageButton($label, $page, $class, $hidden, $selected) {
        if ($hidden || $selected){
            $class .= ' ' . ($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        }
        
        $options = array(
            'class'=>$this->selectedAnchorCss
        );
        return '<li class="' . $class . '">' . CHtml::link($label, $this->createPageUrl($page), $options) . '</li>';
    }
}

?>
