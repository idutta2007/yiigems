<?php

/**
 * A site footer widget that allows displaying a set of links in columns.
 *
 * The SectionSiteFooter widget allows creating a set of links in columns suitable for displaying as footer of an web page.
 * The content of the widget is automatically aligned horizontally to center position.  In addition the SectionSiteFooter
 * can contain arbitrary content before and after these set of links.
 *
 * <pre>
 *
 * $this->beginWidget('ext.yiigems.widgets.siteFooter.SectionSiteFooter', array(
 *     'gradient' => "silver1",
 *     'startContent' => $startContent,  // content to be placed at the start
 *     'sections'=>array(
 *         array(
 *           'title'=> "Section 1",
 *           'items'=>array(
 *               array('label' => 'Option 1', 'url' => array("site/index")),
 *               array('label' => 'Option 2', 'url' => array("site/index")),
 *               array('label' => 'Option 3', 'url' => array("site/index")),
 *               array('label' => 'Option 4', 'url' => array("site/index")),
 *               array(
 *                  'itemType' => 'action',
 *                  'label' => 'Action 1',
 *                  'script' => "alert('you pressed an action button');",
 *               ),
 *              array(
 *                 'itemType' => 'submit',
 *                'label' => 'Submit 1',
 *              ),
 *           )
 *        ),
 *        array(
 *           'title'=> "Section 2",
 *           'items'=>array(
 *               array('label' => 'Option 1', 'url' => array("site/index")),
 *               array('label' => 'Option 2', 'url' => array("site/index")),
 *               array('label' => 'Option 3', 'url' => array("site/index")),
 *               array('label' => 'Option 4', 'url' => array("site/index")),
 *               array('label' => 'Option 5', 'url' => array("site/index")),
 *               array('label' => 'Option 6', 'url' => array("site/index")),
 *          )
 *        )
 *        array(
 *           'title'=> "Section 3",
 *           'items'=>array(
 *               array('label' => 'Option 1', 'url' => array("site/index")),
 *               array('label' => 'Option 2', 'url' => array("site/index")),
 *               array('label' => 'Option 3', 'url' => array("site/index")),
 *               array('label' => 'Option 4', 'url' => array("site/index")),
 *               array('label' => 'Option 5', 'url' => array("site/index")),
 *               array('label' => 'Option 6', 'url' => array("site/index")),
 *           )
 *        )
 *        array(
 *           'title'=> "Section 4",
 *           'items'=>array(
 *               array('label' => 'Option 1', 'url' => array("site/index")),
 *               array('label' => 'Option 2', 'url' => array("site/index")),
 *               array('label' => 'Option 3', 'url' => array("site/index")),
 *               array('label' => 'Option 4', 'url' => array("site/index")),
 *               array('label' => 'Option 5', 'url' => array("site/index")),
 *               array('label' => 'Option 6', 'url' => array("site/index")),
 *            )
 *        )
 * ));
 *
 *   [Any content here]
 *
 * $this->endWidget()?>
 *
 * </pre>
 *
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.siteFooter
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.behave.LinkContainerBehavior");
Yii::import("ext.yiigems.widgets.siteFooter.SectionSiteFooterDefaults");

class SectionSiteFooter extends AppWidget{
    /**
     * @var strung the background gradient of the footer.
     */
    public $gradient;

    /**
     * @var string the background color of the footer.
     * IF this property is set, the $gradient property is ignored.
     */
    public $backgroundColor;

    /**
     * @var string name of the company to displayed on the footer.
     */
    public $companyLabel;

    /**
     * @var string the URL of the company web page to which the company label is linked.
     */
    public $companyUrl;

    /**
     * @var bool specifies whether to display the copyright message at the bottom of the footer.
     */
    public $showCopyright;

    /**
     * @var array the HTML options for sections that contains the links.
     */
    public $sections = array();

    /**
     * @var array the HTML options for the container element.
     */
    public $options = array();

    /**
     * @var array the HTML options for each section.
     */
    public $sectionOptions = array();

    /**
     * @var array the HTML options for the list in a section.
     */
    public $listOptions = array();

    /**
     * @var array the HTML options for the list item.
     */
    public $listItemOptions = array();

    /**
     * @var array the HTML options for the anchor elements.
     */
    public $anchorOptions = array();

    /**
     * @var array the HTML options for the company link.
     */
    public $companyAnchorOptions = array();

    /**
     * @var array HTML options for the copyright text.
     */
    public $copyrightTextOptions = array();

    /**
     * @var string the content that is displayed at the start of the footer.
     */
    public $startContent;

    /**
     * @var string the skin class associated with the footer.
     */
    protected $skinClass = "SectionSiteFooterDefaults";

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
              "sectionFooter.css",
              dirname(__FILE__) . "/assets"
        );
        $this->addGradientAssets($this->gradient);
    }

    /**
     * @return array the list of properties copied from skin class.
     */
    public function getCopiedFields(){
        return array( 
            "gradient", "companyLabel", 
            "companyUrl", "showCopyright"
        );
    }

    /**
     * @return array the list of properties merged from skin class.
     */
    public function getMergedFields(){
        return array( 
            "options", "sectionOptions", 
            "listOptions", "listItemOptions", "anchorOptions",
            "companyAnchorOptions", "copyrightTextOptions"
        );
    }

    /**
     * Sets the properties to default values based on current skin.
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        if(!$this->id) $this->id = UniqId::get("ssf-");
    }

    /**
     * Registers assets and generates all markups including the sections.
     */
    public function init() {
        parent::init();
        $this->registerAssets();
        $this->attachBehavior("linkCont", new LinkContainerBehavior());
        
        echo CHtml::openTag( "div", $this->getContainerOptions());
        
        // render start content
        if ( $this->startContent ) echo $this->startContent;
        
        // redner sections
        echo CHtml::openTag( "div", $this->getSectionsContainerOptions());
        foreach( $this->sections as $section ){
            $this->renderSection( $section );
        }
        echo CHtml::closeTag( "div");
    }

    /**
     * @param $section specifies a section to be rendered.
     */
    protected function renderSection($section){
        echo CHtml::openTag( "div", array('class'=>"section"));

        echo CHtml::openTag( "h1", $this->getSectionHeaderOptions());
        echo $section['title'];
        echo CHtml::closeTag( "h1");

        echo CHtml::openTag( "ul", $this->getListOptions($section['items']));
        foreach( $section['items'] as $item ){
            echo CHtml::openTag( "li", $this->getListItemOptions($item));
            $item['labelMarkup'] = $this->getItemLabel($item);
            $item['anchorOptions'] = $this->getAnchorOptions($item);
            $this->renderItem($item );
            echo CHtml::closeTag( "li" );
        }
        echo CHtml::closeTag( "ul");
        echo CHtml::closeTag( "div");
    }

    /**
     * Renders the copyright message.
     */
    protected function renderCopyrightSection(){
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
     * Renders the closing tags of this widget.
     */
    public function run() {
        if ( $this->showCopyright){
            $this->renderCopyrightSection();
        }
        
        // Main div
        echo CHtml::closeTag( "div" );
    }

    /**
     * @return array the HTML options for the main container.
     */
    public function getContainerOptions(){
        $class = "siteFooter";
        $style = null;
        if ( $this->backgroundColor ){
            $style = "background-color:$this->backgroundColor";
        }
        else if ($this->gradient){
            $class .= " background_$this->gradient";
        }
        return array_merge(array(
            'class'=>$class,
            'style'=>$style,
            'id'=>$this->id
        ), $this->options);
    }

    /**
     * @return array HTML options for the section container.
     */
    public function getSectionsContainerOptions() {
        return array(
            'class'=>'sections'
        );
    }

    /**
     * @param $section specifies a section on the footer.
     * @return array the HTML options for section.
     */
    public function getSectionOptions($section){
        $options = array_key_exists("options", $section) ? $section['options'] : array();
        $class = "siteFooter_section";
        return array_merge(array(
            'class'=>$class,
        ), $this->sectionOptions, $options);
    }
    
    public function getSectionHeaderOptions(){
        $class = "title";
        if ( $this->gradient ){
            $class .= " color_$this->gradient";
        }
        return array(
            'class'=>$class,
        );
    }
    
    public function getListOptions($items){
        $options = array_key_exists("options", $items) ? $items['options'] : array();
        return array_merge($this->listOptions, $options);
    }
    
    public function getListItemOptions($item){
        $options = array_key_exists("options", $item) ? $item['options'] : array();
        return array_merge($this->listItemOptions, $options);
    }
    
    public function getAnchorOptions($item){
        $options = array_key_exists("options", $item) ? $item['options'] : array();
        $options['id'] = array_key_exists("id", $options) ? $options['id'] : UniqId::get("lnk-");
        if ($this->gradient ){
            $options['class'] = "color_$this->gradient hover_color_$this->gradient active_color_$this->gradient";
        }
        return array_merge($this->anchorOptions, $options);
    }

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
