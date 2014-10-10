<?php
/**
 * Description of PhotoBooth
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.photoBooth
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");

class PhotoBooth extends AppWidget {
    public $width = "300px";
    public $height = "200px";
    public $imageHolderId="";
    public $inputFieldId="";
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
            "photobooth.min.js",
            dirname(__FILE__) . "/assets"
        );
    }
    
    public function setMemberDefaults() {
        $this->id = UniqId::get("phb-");
    }
    
    /**
     * Initializes the gradient button.
     * Register all assets after copying property values from the skin class and
     * produces all markups except the end tag. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag("div", array(
            'id'=>$this->id,
            'style'=>StyleUtil::createStyle(array(
                'width'=>$this->width,
                'height'=>$this->height,
            ))
        ));
        echo CHtml::closeTag("div");
    }
    
    public function run(){
        $this->registerClientScript();
    }
    
    private function registerClientScript(){
        Yii::app()->clientScript->registerScript( UniqId::get("scr-"), "
           $('#$this->id').photobooth().on('image', function(ev, dataUrl){
                if ( '$this->imageHolderId'!=''){
                    $('#$this->imageHolderId').empty();
                    $('#$this->imageHolderId').append('<img src=\"' + dataUrl + '\">');
                }
                if ( '#$this->inputFieldId'!=''){
                    $('#$this->inputFieldId').attr('value', dataUrl);
                }
            });
        ");
    }
}

?>
