<?php

/**
 * Widget to create a list of bullet items where icon and style associated with
 * each item can be set.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @package ext.yiigems.widgets.lists
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import( "ext.yiigems.widgets.common.AppWidget");
Yii::import( "ext.yiigems.widgets.lists.SimpleListDefaults");

class SimpleList extends AppWidget{
    public $listTag;
    public $listOptions;
    
    public $itemTag;
    public $itemContentWrapper;
    public $itemIconClass;
    
    public $skinClass = "SimpleListDefaults";
    
    /**
     * Sets up asset information for the label. 
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "simpleList.css", dirname(__FILE__) . "/assets" );
        $this->addAssetInfo( "simpleList.js", dirname(__FILE__) . "/assets" );
    }
    
    /**
     * @return array the list of properties to be set from skin class. 
     */
    protected function getCopiedFields(){
        return array(
            "listTag", "itemTag", "itemContentWrapper", "itemIconClass"
        );
    }
    
    /**
     * @return array the list of properties to be merged from the akin class. 
     */
    protected function getMergedFields(){
        return array( "listOptions" );
    }
    
    public function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("simplist-");
    }
    
    /**
     * Initializes this widget by generaing all markups. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        echo CHtml::openTag( $this->listTag, $this->computeListOptions());
    }
    
    public function computeListOptions(){
        $options = array( 
            'class'=> 'simpleList',
            'id'=> $this->id
        );
        return ComponentUtil::mergeHtmlOptions($options, $this->listOptions);
    }
    
    public function run(){
        echo CHtml::closeTag( $this->listTag );
        
        Yii::app()->clientScript->registerScript( UniqId::get("src-"), "
            $('#$this->id').simpleList({
                itemTag: '$this->itemTag',
                itemContentWrapper: '$this->itemContentWrapper',
                itemIconClass: '$this->itemIconClass'
            });
        ");
    }
}

?>
