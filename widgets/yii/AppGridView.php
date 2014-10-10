<?php

/**
 * AppGridView class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.yii
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("zii.widgets.grid.CGridView");
Yii::import("ext.yiigems.widgets.common.behave.WidgetBehavior");
Yii::import("ext.yiigems.widgets.yii.AppGridViewDefaults");

class AppGridView extends CGridView {
    public $headerGradient;
    public $promptForDelete = null;
    public $deleteConfirmMessage = null;
    public $defaultTemplate = null;
    public $registerDeleteScript = true;
    
    public function init(){
        $this->attachBehavior( "widget", new WidgetBehavior());
        
        $this->setMemberDefaults();
        $this->setupAssetInfo();
        $this->registerAssets();
        
        $this->template = $this->defaultTemplate ? $this->defaultTemplate : $this->getDefaultTemplate();
        $this->cssFile = $this->getAssetPublishPath("gridview.css") . "/gridview.css";
        $this->pager = array(
            'class'=>'CLinkPager',
            'cssFile'=> $this->getAssetPublishPath("pager.css") . "/pager.css",
        );
        parent::init();
        
        // Add prompt for deletion
        if ( $this->registerDeleteScript && $this->promptForDelete ){
            $this->registerDeleteScript($this->deleteConfirmMessage);
        }
    }
    
    public function getDefaultTemplate(){
        $seperator1 = UIHelper::clearBoth( "5px");
        $seperator2 = UIHelper::clearBoth( "10px");
        $seperator3 = UIHelper::clearBoth( "5px");
        return "{summary}$seperator1{pager}$seperator2{items}$seperator3{pager}";
    }
    
    public function setMemberDefaults(){
        if( !$this->headerGradient ) $this->headerGradient = AppGridViewDefaults::$headerGradient;
        if( !$this->promptForDelete ) $this->promptForDelete = AppGridViewDefaults::$promptForDelete;
        if( !$this->deleteConfirmMessage ) $this->deleteConfirmMessage = AppGridViewDefaults::$deleteConfirmMessage;
    }
    
    public function setupAssetInfo(){
        $this->addAssetInfo(
             "gridview.css",
             dirname(__FILE__) . "/assets/gridview"
        );
        
        $this->addAssetInfo(
             "pager.css",
             dirname(__FILE__) . "/assets/pager"
        );
        
        $this->addAssetInfo(
                "cssGemsCommon.css", 
                $this->getCommonAssetDir()
        );
        
        if ($this->headerGradient) {
            $this->addAssetInfo(
                "$this->headerGradient.css", 
                $this->getGradientAssetDir( $this->headerGradient)
            );
        }
    }
    
    public function renderTableHeader() {
        if (!$this->hideHeader) {
            echo "<thead>\n";

            if ($this->filterPosition === self::FILTER_POS_HEADER)
                $this->renderFilter();

            echo "<tr class='background_$this->headerGradient'>\n";
            foreach ($this->columns as $column)
                $column->renderHeaderCell();
            echo "</tr>\n";

            if ($this->filterPosition === self::FILTER_POS_BODY)
                $this->renderFilter();

            echo "</thead>\n";
        }
        elseif ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }
    
    public function registerDeleteScript($message) {
        // Include impromptu assets
        $dlg = Yii::app()->controller->widget("ext.yiigems.widgets.impromptu.Impromptu");
        $markup = $dlg->createErrorMarkup("MESSAGE");
        $markup = trim(preg_replace('/\s\s+/', ' ', $markup));
        
        // Note-the function assumes two variables url and th are defined in scope
        // th is the delete button, url id the delete url
        $impromptuScript = $dlg->getConfirmationPopupScript($message, "function(v,m,f){
             if (v==null || v==false) return;
             $.fn.yiiGridView.update('$this->id', {
                type:'POST',
                url: url,
                success:function(data) {
                     $.fn.yiiGridView.update('$this->id');
                },
                error:function(xhr) {
                     var markup = '$markup';
                     markup = markup.replace( 'MESSAGE', xhr.responseText );
                     $.prompt( markup, {
                        top: '30%',
                        opacity: 0.40,
                        buttons:{ Close:true },
                        callback: function(){}
                     });;
                     return false;
                }
             });
         }");
        Yii::app()->clientScript->registerScript("{$this->id}_Delete", "
            jQuery('#$this->id a.custDelete').live('click',function() {
                var th = this;
                var afterDelete = function(){};
                var url = $(this).attr('href');
                $impromptuScript
                return false;
            });
        ");
    }
}
?>
