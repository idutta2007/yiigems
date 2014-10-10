<?php

/**
 * An widget to create a simple site footer. The SiteFooter widget allows you to create a simple footer for your web
 * page with few links and a copyright message.
 *
 * <pre>
 *
 * $this->widget("ext.yiigems.widgets.siteFooter.SiteFooter", array(
 *     'companyLabel' => "My Company",
 *     'companyUrl' => "http://www.yiigems.com",
 *     'items'=>array(
 *          array('label'=>'Home', "url"=>array('/site/index')),
 *          array('label'=>'About Us', "url"=>array('/site/aboutUs')),
 *          array('label'=>'Terms Of Use', "url"=>array('/site/terms')),
 *          array('label'=>'Contact Us', "url"=>array('/site/contact')),
 *      )
 * ));
 *
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.siteFooter
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.siteFooter.SiteFooterDefaults");

class SiteFooter extends AppWidget {
    /**
     * @var string the name of the background gradient for this footer.
     */
    public $gradient;

    /**
     * @var string the name of the company or organization in the copyright message.
     */
    public $companyLabel = "YiiGems";

    /**
     * @var string the URL for the company or organization
     */
    public $companyUrl = "http://www.yiigems.com";

    /**
     * @var array the list of links to be displayed in this footer.
     */
    public $items = array();

    /**
     * @var array the HTML options for the container element.
     */
    public $options = array();

    /**
     * @var array options for each anchor element.
     */
    public $anchorOptions = array();

    /**
     * @var array HTML options for the company anchor.
     */
    public $companyAnchorOptions = array();

    /**
     * @var array HTML options for the copyright message.
     */
    public $copyrightTextOptions = array();

    /**
     * @var string the skin class associated with this widget.
     */
    protected $skinClass = "SiteFooterDefaults";

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
              "basic.css",
              dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->gradient);
    }

    /**
     * @return array the list of properties copied from the skin class.
     */
    public function getCopiedFields(){
        return array( "gradient" );
    }

    /**
     * @return array the list of properties merged from the skin class.
     */
    public function getMergedFields(){
        return array( 
            "options", "anchorOptions",
            "companyAnchorOptions", "copyrightTextOptions"
        );
    }

    /**
     * Initializes this widget by registering all assets and then generating required markups.
     */
    public function init() {
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag( "div", $this->getContainerOptions());
        
        // Add the links
        echo CHtml::openTag( "div", array('class'=>"links"));
        foreach( $this->items as $item ){
            $label = $this->getItemLabel($item);
            $url = array_key_exists('url', $item) ? $item['url'] : "javascript:void(0)";
            echo Chtml::link( $label, $url, $this->getItemOptions($item) );
        }
        echo CHtml::closeTag( "div" );
        
        // Add the copyright section
        echo CHtml::openTag( "div", array('class'=>'copyright'));
        
        echo CHtml::openTag( "span", $this->copyrightTextOptions);
        echo "Copyright &copy;" . date('Y'). " by";
        echo CHtml::closeTag( "span" );
        
        echo CHtml::openTag( "span", array('class'=>'company') );
        echo Chtml::link( $this->companyLabel, $this->companyUrl, $this->companyAnchorOptions );
        echo CHtml::closeTag( "span" );
        
        echo CHtml::openTag( "span", $this->copyrightTextOptions);
        echo "All Rights Reserved.";
        echo CHtml::closeTag( "span" );
        
        echo CHtml::closeTag( "div" );
        
        
    }

    /**
     * Produces the closing tag.
     */
    public function run() {
        // Main div
        echo CHtml::closeTag( "div" );
    }

    /**
     * @return array HTML options for the main container element.
     */
    public function getContainerOptions(){
        $class = "siteFooter_basic";
        if ($this->gradient){
            $class .= " background_$this->gradient";
        }
        return array_merge(array(
            'class'=>$class,
            'id'=>$this->id
        ), $this->options);
    }

    /**
     * @param $item specifies a link to be displayed at the footer.
     * @return array HTML options for the item.
     */
    public function getItemOptions($item){
        $options = array_key_exists("options", $item) ? $item['options'] : array();
        return array_merge($options, $this->anchorOptions);
    }

    /**
     * @param $item specifies a footer item.
     * @return string the label for the footer item.
     */
    public function getItemLabel($item) {
        $label = array_key_exists("label", $item) ? $item['label'] : "NotSet";
        
        if (array_key_exists("iconClass", $item)){
            $iconClass = $item['iconClass'];
            $label = "<span class='$iconClass'>$label</span>";
        }
        return $label;
    }
}
?>
