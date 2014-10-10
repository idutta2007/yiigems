<?php

/**
 * AppListView class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.yii
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("zii.widgets.CListView");
Yii::import("ext.yiigems.widgets.common.behave.WidgetBehavior");

class AppListView extends CListView {
    public $publishPath;
    public $deleteConfirmMessage = null;
    
    public function init(){
        $this->attachBehavior( "widget", new WidgetBehavior());
        
        $this->publishAssets();
        parent::init();
        
        // Add prompt for deletion
        if ( $this->deleteConfirmMessage ){
            $this->registerDeleteScript($this->deleteConfirmMessage);
        }
    }
    
    private function publishAssets(){
        $path = dirname(__FILE__) . "/assets";
        $this->publishPath = Yii::app()->getAssetManager()->publish( $path );
    }
    
    public function registerDeleteScript($message) {
        $dlg = Yii::app()->controller->widget("ext.yiigems.widgets.impromptu.Impromptu");
        
        $warningScript = $dlg->getWarningPopupScript( "Delete Failed" );
        
        // Note-the function assumes two variables url and th are defined in scope
        // th is the delete button, url is the delete url
        $impromptuScript = $dlg->getConfirmationPopupScript($message, "function(v,m,f){
             if (v==null || v==false) return;
             $.fn.yiiListView.update('$this->id', {
                type:'POST',
                url: url,
                success:function(data) {
                     $.fn.yiiListView.update('$this->id');
                },
                error:function(XHR) {
                     $warningScript
                     return false;
                }
             });
         }");
        Yii::app()->clientScript->registerScript("{$this->id}_Delete", "
            $(document).on( 'click', '#$this->id a.custDelete', function() {
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
