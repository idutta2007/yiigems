<?php
/**
 * A wrapper around JQuery plugin jcarousel.
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.jcrousel
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class JCarousel extends AppWidget {
    public $containerTag = "div";
    public $containerOptions = array(
        'style' => "width:600px;height:300px"
    );
    public $itemTag = "div";
    public $itemOptions = array();
    
    public $scenario = "horizontal";
    
    public $jcarouselOptions = array( 'perPage' => 1 );
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
            "jcarousel.min.js",
            dirname(__FILE__) . "/assets"
        );
        $this->addAssetInfo(
            "$this->scenario.css",
            dirname(__FILE__) . "/assets"
        );
    }
    
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("jcrsl-");
    }
    
    public function init(){
        parent::init();
        $this->registerAssets();
        echo CHtml::openTag($this->containerTag, $this->getContainerOptions());
    }
    
    protected function getContainerOptions(){
        $options = array();
        $options['id'] = $this->id;
        $options['class'] = 'jcarousel';
        return ComponentUtil::mergeHtmlOptions($options, $this->containerOptions );
    }
    
    public function run(){
        echo CHtml::closeTag($this->containerTag);
        
        $params = "";
        if (count($this->jcarouselOptions) > 0){
            foreach( $this->jcarouselOptions as $key => $value ){
                if ( is_string($value)){
                    $params .= "$key: '$value',";
                }
                else {
                    $params .= "$key: $value,";
                }
            }
        }
        $params = $params ? substr($params, 0, strlen($params)-1): "";
        
        Yii::app()->clientScript->registerScript( UniqId::get("scr-"), "
            \$('#$this->id').jcarousel({
                $params
            });
            \$('.jcarousel-prev').jcarouselControl({
                target: '-=1'
            });

            \$('.jcarousel-next').jcarouselControl({
                target: '+=1'
            });
            
            \$('#$this->id').jcarouselAutoscroll({
                interval: 4000,
                target: '+=1',
                autostart: true
            });
        ");
    }
}

?>
