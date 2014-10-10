<?php

/**
 * Highlighter is a wrapper around the syntax highlighter script highlight.js.
 * Highlighter widget can be used to highlight codes syntax on any web page. It
 * supports around 54 different languages. Here is an example of using the 
 * Highlighter widget to display PHP code. For all the languages supported by this widget and
 * available styles see the documentation for highlight.js.
 * 
 * <pre>
 * 
 * <?php Yii::app()->controller->beginWidget("ext.yiigems.widgets.highlighter.Highlighter", array(
 *     'language' => "php"
 *  ));?>
 * // Place your code here after setting the language attribute correctly.
 * $items = array(
 *       array( 'label'=>"Job Applicants", 'items'=>array(
 *                       array( 'label'=>"Manage Applicants", 'url'=>"javascript:void(0)" ),
 *                       array( 'label'=>"Search Applicants", 'url'=>"javascript:void(0)" ),
 *                       array( 'label'=>"Add an Applicant", 'url'=>"javascript:void(0)" ),
 *       )),
 *       array( 'label'=>"Placements", 'items'=>array(
 *                       array( 'label'=>"Manage placements", 'url'=>"javascript:void(0)" ),
 *                       array( 'label'=>"Search placement", 'url'=>"javascript:void(0)" ),
 *                       array( 'label'=>"Add a Placement", 'url'=>"javascript:void(0)" ),
 *       )),
 *       array( 'label'=>"Employers", 'items'=>array(
 *                       array( 'label'=>"Manage Employers", 'url'=>"javascript:void(0)"),
 *                       array( 'label'=>"Search Employers", 'url'=>"javascript:void(0)" ),
 *                       array( 'label'=>"Add an Employer", 'url'=>"javascript:void(0)" ),
 *       )),
 * ));
 * <?php Yii::app()->controller->endWidget();?>
 * 
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.highlighter
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class Highlighter extends AppWidget {
    public $titleText;
    public $height;

    public $theme = "github";
    public $language = "php";
    
    public $options = array();
    public $preOptions = array('style' => 'white-space:pre;font-size:90%;' );
    public $codeOptions = array('style' => 'padding:1em 2em 2em 3em;');

    /**
     * Sets up asset information for this widget.
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->assetsInfo[] = array(
            'name' => "/styles/{$this->theme}.css",
            'assetDir' => dirname(__FILE__) . "/assets/highlight"
        );
        $this->assetsInfo[] = array(
            'name' => "highlight.pack.js",
            'assetDir' => dirname(__FILE__) . "/assets/highlight"
        );
    }

    /**
     * Sets the widget properties to default values.
     */
    protected function setMemberDefaults(){
        $this->id = $this->id ? $this->id : UniqId::get( "code-");
    }

    /**
     * Initializes this widget and produces the opening markup.
     */
    public function init(){
        parent::init();
        $this->registerAssets();

        // If there is s title text use a title box
        if ( $this->titleText ){
            $this->beginWidget( "ext.yiigems.widgets.titleBox.TitleBox", array(
                'titleText' => $this->titleText,
                'collapsible' => true,
                'rightIconClass' => 'icon-code pull-right',
            ));
        }

        // render code section
        echo CHtml::openTag( "div", $this->computeContainerOptions());
        echo CHtml::openTag( "pre", $this->getPreOptions());
        echo CHtml::openTag( "code", $this->getCodeOptions());
    }

    public function computeContainerOptions(){
        if ( $this->titleText ){
            $style = array(
                'border' => '0px solid gray',
                'margin' => '0em 0em 0em 0em',
                'height' => $this->height,
                'overflow' => $this->height ? 'scroll': null,
            );
        }
        else {
            $style = array(
                'border' => '1px solid gray',
                'margin' => '1em 0em 1em 0em',
                'height' => $this->height,
                'overflow' => $this->height ? 'scroll': null,
            );
        }
        $options = array( 'style'=> StyleUtil::createStyle($style) );
        return ComponentUtil::mergeHtmlOptions( $options, $this->options );
    }
    
    public function getPreOptions(){
        return $this->preOptions;
    }
    
    public function getCodeOptions(){
        $options = array('id'=> $this->id );
        $options['class'] = $this->language;
        if ( $this->titleText ) $options['style'] = "background:transparent";
        return ComponentUtil::mergeHtmlOptions($options, $this->codeOptions);
    }

    /**
     * Produces the closing tags for this widget.
     */
    public function run(){
        echo CHtml::closeTag("code");
        echo CHtml::closeTag("pre");
        echo CHtml::closeTag("div");

        // End the title box if there was one started
        if ( $this->titleText ) {
            echo UIHelper::verticalStrut("10px");
            $this->endWidget();
        }

        Yii::app()->clientScript->registerScript(UniqId::get("scr-"), "
            hljs.highlightBlock($('#$this->id').get(0));
        ");
    }
}

?>
