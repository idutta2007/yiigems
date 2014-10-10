<?php

/**
 * An widget to create complex forms involving multiple models.
 * 
 * The ActiveModelForm class is designed to create complex forms with multiple
 * sections involving multiple CModel objects. It uses a declarative syntax
 * to layout form elements to make laying out of form elements easy and intuitive.
 * ActiveModelForm divides the form into sections and in each section the form
 * elements are laid out in row major order. The form elements, for each attribute of
 * the model, can occupy one or more cells. For each cell it is possible to specify 
 * the rowspan, colspan and whether the form should wrap to the next row after 
 * adding the cell. Here are a few examples how the form elements for the column 
 * named first_name can be  added to the form:
 * 
 * <pre>
 *     $form->add( $model, "first_name", "[labelEx/textField/hintOrError wrap]" );
 * </pre>
 * In the above example, the label, the textfield, the hint and the error message
 * all are placed in one cell as indicated by the square brackets. Each pair of
 * matching sqaure brackets denotes a cell. Since the label, the textfield, the hint
 * and the error message are placed in the same cell, the label will appear above the 
 * textfield and
 * the hint or error will appear below the textfield. The wrap keyword indicates 
 * that layout should wrap to the next row after adding the form elements 
 * for first_name.
 * 
 * If you want to put the label and the textfield in separate cells in the same row 
 * you will do it as follows:
 * <pre>
 *     $form->add( $model, "first_name", "[labelEx][textField/hintOrError wrap]" );
 * </pre>
 * 
 * You can put the label, the textfield and the hint in separate cells as well.
 * <pre>
 *     $form->add( $model, "first_name", "[labelEx][textField][hintOrError wrap]" );
 * </pre>
 * 
 * You can make the textfield occupy two columns by specifying the span keyword.
 * <pre>
 *     $form->add( $model, "first_name", "[labelEx][textField span 2][hintOrError wrap]" );
 * </pre>
 * 
 * Adding form elements for two model attributes in the same row is simple. Note
 * below the use of keyword wrap for the last_name model attribute.
 * <pre>
 *     $form->add( $model, "first_name", "[labelEx][textField/hintOrError]" );
 *     $form->add( $model, "last_name", "[labelEx][textField/hintOrError wrap]" );
 * </pre>
 * 
 * Here is an example of an address form:
 * <pre>
 * 
 * $form = $this->beginWidget("ext.yiigems.widgets.form.ActiveModelForm", array(
 *   // itemsConfig array specifies configuration for the form elements.
 *   'itemsConfig' => array(
 *       array( $model, "address_line1, address_line3", array(
 *           'textField'=>array(
 *               'htmlOptions' => array('size' => 40, 'maxlength' => 128),
 *           ),
 *       )),
 *       array( $model, "address_line1", array(
 *           'hint' => 'Enter your Apt number here if applicable'
 *       ))
 *       array( $model, "address_line1", array(
 *              'hint' => 'Enter your Apt number here if applicable'
 *       )),
 *       array( $model, "zip", array(
  *          'textField'=>array(
 *               'htmlOptions' => array('size' => 6, 'maxlength' => 12),
 *           ),
 *       )),
 *    )
 * ));
 *
 * $form->startSection( "*", "*"  ); // This section has two columns
 * $form->add( $model, "address_line1", "[labelEx/textField/hintOrError]");
 * $form->add( $model, "address_line2", "[labelEx/textField/hintOrError wrap]");
 * $form->add( $model, "state", "[labelEx/textField/hintOrError]");
 * $form->add( $model, "city", "[labelEx/textField/hintOrError wrap]");
 * $form->add( $model, "zip", "[labelEx/textField/hintOrError wrap]");
 * $form->endSection();
 * 
 * // The submit button section adds the form action buttons
 * $form->submitButtonSection( "[submitButton wrap]");
 * 
 * $this->endWidget();
 * 
 * </pre>
 * 
 * For some more examples see this {@link http://www.yiigems.com/index.php/site/page?view=demo.form.formLayout page}.
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");
Yii::import("ext.yiigems.widgets.common.behave.WidgetBehavior");
Yii::import("ext.yiigems.widgets.common.utils.StyleUtil");
Yii::import("ext.yiigems.widgets.form.ActiveModelFormDefaults");
Yii::import("ext.yiigems.widgets.form.common.FieldSpec");
Yii::import("ext.yiigems.widgets.form.behaviors.FormBehaviorEx1");
Yii::import("ext.yiigems.widgets.form.behaviors.FormBehaviorEx2");
Yii::import("ext.yiigems.widgets.form.behaviors.FormBehaviorEx3");
Yii::import("ext.yiigems.widgets.form.FormConfigUtil");

class ActiveModelForm extends AppWidget {
    /**
     * @var array of global configuration for form elements. Each entry in this array 
     *  specifies default attributes of a form element inside this form. 
     * An example is as follows:
     * array(
     *     'label' => array(
     *         'htmlOptions'  => array(style=> "color:blue", 'class'=> 'formLabel')
     *     ),
     *     'textField' => array(
     *         'htmlOptions'  => array(style=> "border:1px solid gray", 'class'=> 'formText')
     *     ),
     * )
     */
     public $formConfig = array();
    
    /**
     * @var array Specifies configuration for elements bound to model fields.  
     * For example,
     * array(
     *    array( $model, "firstName", array (
     *         'hint' => array(
     *              message => "First Name must have at least two characters"
     *         ),
     *         'label' => array(
     *               required=> true,
     *               htmlOptions => array( 'style'=>'color:red')
     *         ),
     *         'textField'=> array(
     *              "htmlOptions" => array( 'size' => 40, "maxlen" => 128 )
     *         }
     *     )
     * )
     */
    public $itemsConfig = array();
    
    /** The contai8ner tag for the form widget. This is a div tag by default */
    public $containerTag;
    
    /**
     * @var array options for the container of the form element.
     * This is useful if you have to set any attribute of the container, for
     * example, say to restruct the width or height of the form.
     */
    public $containerOptions = array();

    /**
     * @var the action URL for the form- defaults to null
     */
    public $action = "";

    /**
     * @var the HTTP meyhod used by the form - defaults to POST.
     */
    public $method = "POST";

    /** Specifies whether this is a sateful form */
    public $stateful = false;

    /**
     * @var array the HTML options for the form tag.
     */
    public $formOptions = array();

    /**
     * @var string the style for the separator displayed in the submit secion. 
     */
    public $submitSectionRulerStyle = "height:1px;border-top:1px dotted black;margin-top:0.5em;margin-bottom:0.5em";
    
    /**
     * @var string The icon to be displayed on the submit button 
     */
    public $submitIconClass;
    
    /**
     * @var strng The label of the submit button.
     * Defaults to the string "Save" 
     */
    public $submitButtonLabel;
    
    /**
     * @var string The confirmation message to be displayed before submitting the form.
     * If this string is not null, a confirmation message will be displayed to the
     * user and the form will be submitted only after user approves the operation.  
     */
    public $submitConfirmMessage;
    
    /** 
     * Whether to add an invisible submit button so that pressing enter on text
     * fields will submit the form.
     */
    public $addInvisibleSubmitButton;
    
    
    /** javascript executed before submitting form */
    public $submitHandlerCode = "";
    
    /** The default option for the table in a section */
    public $defaultSectionOptions = array('class'=>'form', 'style' => "width:auto");
    
    /** Configuration options for input groups created in this form */
    public $inputGroupConfig = array();
    
    /**
     * @var integer Used internally to keep track of number of columns in current section. 
     */
    protected $number_of_columns = 1;
    
    /**
     * @var array widths of the columns in current section. Used internally by form.
     */
    protected $columnWidths = array();
    
    /**
     * @var boolean Whether a row has been started by adding a form element. 
     */
    private $rowStarted = false;

    /** The skin class associated with this widget */
    protected $skinClass = "ActiveModelFormDefaults";
    
    protected $rowIndex = 0;
    
    /**
     * Sets up asset information for this widget.
     * @see AppWidget::setupAssetsInfo
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo(
            "form.css",
            dirname(__FILE__) . "/assets"
        );
    }

    public function getCopiedFields(){
        return array(
            "containerTag",
            "submitSectionRulerStyle",
            "submitIconClass", "submitButtonLabel", "submitConfirmMessage",
            "addInvisibleSubmitButton"
        );
    }

    public function getMergedFields(){
        return array( "containerOptions", "formOptions" );
    }
    
    /**
     * Sets the values of widget properties to default values.
     * @see AppWidget::setMemberDefaults
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        $this->id = $this->id ? $this->id : UniqId::get("form-");
        
        // Normalize formConfig
        $util = new FormConfigUtil();
        $this->formConfig= $util->normalizeFormConfig($this->formConfig);
        $this->itemsConfig= $util->normalizeItemConfigs($this->itemsConfig);
        
        // merge from ActiveModelFormDefaults into $this->formConfig
        foreach( ActiveModelFormDefaults::$formConfig as $formElem=>$options){
            if ( !array_key_exists( $formElem, $this->formConfig ) ) $this->formConfig[$formElem] = array();
            $this->formConfig[$formElem] = array_merge($options, $this->formConfig[$formElem] );
            if ( array_key_exists( "htmlOptions", $options) && array_key_exists( "htmlOptions", $this->formConfig[$formElem]) ){
                $this->formConfig[$formElem]["htmlOptions"] = ComponentUtil::mergeHtmlOptions($options["htmlOptions"], $this->formConfig[$formElem]["htmlOptions"]);
            }
        }
    }
    
    /**
     * Initializes this widget.
     * @see CWidget::init
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        // Attch form behavior for extra functionalities
        $this->attachBehavior("ex1", new FormBehaviorEx1() );
        $this->attachBehavior("ex2", new FormBehaviorEx2() );
        $this->attachBehavior("ex3", new FormBehaviorEx3() );
        
        echo CHtml::openTag("div", $this->computeContainerOptions() );

        if($this->stateful){
            echo CHtml::statefulForm($this->action, $this->method, $this->computeFormOptions());
        }
        else {
            echo CHtml::beginForm($this->action, $this->method, $this->computeFormOptions());
        }

        // Render hidden fields if any
        $this->renderHiddenFields();
    }
    
    public function run(){
        if ( $this->addInvisibleSubmitButton ){
            echo $this->invisibleSubmitButton();
        }

        echo CHtml::endForm();
        echo CHtml::closeTag( $this->containerTag );
    }

    protected function computeContainerOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'id' => "div-" . $this->id,
            'class'=>'form',
            'addClass' => $this->addClass,
        ));
        return ComponentUtil::mergeHtmlOptions( $options, $this->containerOptions );
    }

    protected function computeFormOptions(){
        $options = array( 'id' => $this->id );
        return ComponentUtil::mergeHtmlOptions( $options, $this->formOptions );
    }
    
    /**
     * Renders the hidden fields associated with the form. 
     */
    public function renderHiddenFields(){
        foreach( $this->itemsConfig as $item ){
            $model = $item[0];
            $column = $item[1];
            $options = $item[2];
            $hidden = array_key_exists("hidden", $options) ? $options['hidden'] : false;
            if ( $hidden ){
                echo CHtml::activeHiddenField($model, $column);
            }
        }
    }
    
    /**
     * Renders a invisible submit button for the form. 
     */
    private function invisibleSubmitButton() {
        echo CHtml::tag("input", array(
            'type' => 'submit',
            'style'=>'position:absolute;left:-9999px;width:1px;height:1px'
        ));
    }
    
    //==========================================================================
    // Methods to render Cell
    //==========================================================================
    /**
     * Adds the form elements for a model attribute to the form in the current
     * location. The string specifies what form elements are added and how many
     * cells are occupied by these elements.  
     * @param object $model An ActiveRecord or CFromModel object.
     * @param string $attribute name of an attribute.
     * @param string $spec Specifies how the attribute is added to the form.
     */
    public function add(){
        $args = func_get_args();
        $spec = array_pop($args);
                
        $fieldSpec = new FieldSpec();
        $fieldSpec->parse($spec);
        foreach( $fieldSpec->cellSpecs as $cellSpec ){
            $markup = "";
            foreach( $cellSpec->components as $component ){
                $markup .= call_user_func_array( array($this, $component), $args );
            }
            if (!$this->rowStarted ) $this->startRow();
            echo $this->cell($markup, $cellSpec->rowspan, $cellSpec->colspan);
            if ( $cellSpec->wrap) $this->endRow();
        }
    }

    
    /**
     * Starts a row in the current section of the form 
     */
    private function startRow(){
        $rowClass = ($this->rowIndex % 2 == 0) ? "even" : "odd";
        echo CHtml::openTag( "tr", array( 'class' => $rowClass));
        $this->rowStarted = true;
    }
    
    /**
     * Ends the row in the current section of the form 
     */
    private function endRow(){
        echo CHtml::closeTag( "tr" );
        $this->rowStarted = false;
        $this->rowIndex++;
    }
    
            
    //==========================================================================
    // Methods related to sections
    //==========================================================================
    /**
     * Starts a form section.
     * Accepts a variable list of string arguments each representing a column
     * width in the section. A column width of "*" means the width is not forced
     * to any particular value but is determined by form layout.
     */
    public function startSection(){
        $sectionOptions = array();
        
        // Get values from args
        $args = func_get_args();
        if (count($args)){
            if (is_array($args[0])){
                $options = $args[0];
                $this->columnWidths = array_key_exists('columnWidths', $options) ? $options['columnWidths'] : $this->columnWidths;
                if (is_string($this->columnWidths)) $this->columnWidths = preg_split('/[,\s;]/', $this->columnWidths, -1, PREG_SPLIT_NO_EMPTY);
                $this->number_of_columns = array_key_exists('numberOfcolumns', $options) ? $options['numberOfcolumns'] : count($this->columnWidths);
                $sectionOptions = array_key_exists('sectionOptions', $options) ? $options['sectionOptions'] : array();
            }
            else if (is_string($args[0])){
                if (func_num_args() == 1 ){
                    $this->columnWidths = preg_split('/[,\s;]/', $args[0], -1, PREG_SPLIT_NO_EMPTY);
                }
                else {
                    $this->columnWidths = func_get_args();
                }
                $this->number_of_columns = count($this->columnWidths);
            }
        }
        
        // Start new section
        echo CHtml::openTag("table", ComponentUtil::mergeHtmlOptions( $this->defaultSectionOptions, $sectionOptions) );
        
        echo CHtml::openTag("tr");
        foreach( $this->columnWidths as $width ){
            if ($width=="*" || $width=="") $width = "auto";
            $options = array('style'=>"width:$width;height:0px;padding:0px");
            echo CHtml::openTag("td" );
            echo CHtml::openTag("div", $options);
            echo CHtml::closeTag("div");
            echo CHtml::closeTag("td");
        }
        echo CHtml::closeTag("tr");
    }
    
    /**
     * End the current form section. 
     */
    public function endSection(){
        if ( $this->rowStarted ) $this->endRow();
        echo CHtml::closeTag("table");
    }
    
    /**
     * Creates a section that displays the error associated with a model
     * @param object $model Specifies an ActiveModel object. 
     */
    public function errorSummarySection($model) {
        echo $model ? CHtml::errorSummary($model) : "";
    }
    
    /**
     * Renders the submit button section. 
     * This can be called only after ending any section that was started.
     * @param type $template indicates how the submit button row is created.
     */
    public function submitButtonSection($template="[submitButton wrap]", $columnWidths = null){
        $options = array(
            'columnWidths' => $columnWidths ? $columnWidths : $this->columnWidths,
            'sectionOptions' => array('class'=>'form', 'style' => 'width:auto')
        );
        
        $this->startSection($options);
        echo $this->horzRule();
        $this->add($template);
        $this->endSection();
    }
    
    //==========================================================================
    // Outside sections
    //==========================================================================
    /**
     * Creates a space between two form sections. 
     * This can be called only after ending any section that was started. Otherwise
     * the result is undefined.
     * @param string $height od the spacing in CSS units.
     */
    public function sectionSpacer($height="20px") {
        echo UIHelper::verticalStrut($height);
    }
    
    /**
     * Adds a title for a section.
     * Should be called before starting a section and after ending any section that
     * was started. In other words this method can not be called inside a section.
     * @param string $title the test for the title.
     * @param array $options Any options for the title.
     */
    public function sectionTitle($title, $options=array() ){
        $con = Yii::app()->controller;
        $con->widget( "ext.yiigems.widgets.title.TitleBar", array_merge(array(
            'titleText'=>$title,
            'scenario' => 'formSectionTitle'
        ), $options));
    }
    
    /**
     * Adds a header title for a section.
     * Should be called before starting a section and after ending any section that
     * was started. In other words this method can not be called inside a section.
     * @param string $title the title for the header.
     * @param array $options Any options for the title.
     */
    public function sectionHeader($title, $options=array()) {
        $options['titleText'] = $title;
        $options['scenario'] = 'formSectionHeader';
        $con = Yii::app()->controller;
        $con->widget( "ext.yiigems.widgets.title.TitleHeader", $options);
    }
    
    //==========================================================================
    // Input field cells
    //==========================================================================
    /**
     * Method to create a cell.
     * Should not be called from application directly.
     * @param string $content the content of the cell
     * @param integer $rowspan the number of rows occupied by the cell.
     * @param integer $colspan the number of columns occupied by the cell.
     * @return string the markup for the cell. 
     */
    public function cell( $content, $rowspan=1, $colspan=1 ){
        if ( $rowspan == 0 ) $rowspan = $this->number_of_rows;
        if ( $colspan == 0 ) $colspan = $this->number_of_columns;
        
        if ( $rowspan == 1 ) $rowspan = null;
        if ( $colspan == 1 ) $colspan = null;
        
        $markup = CHtml::openTag( "td", array(
            'class'=>'content',
            'rowspan'=> $rowspan,
            'colspan'=> $colspan,
        ));
        $markup .= $content;
        $markup .= CHtml::closeTag( "td" );
        return $markup;
    }
    
    //==========================================================================
    // All possible Input fields
    //==========================================================================
    /**
     * Creates the markup for the hint associated with a model attribute and returns it.
     * Should not be called from the application directly.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @return string returns the markup for the hint.
     */
    public function hint($model, $column){
        $options = $this->computeElementOptions($model, $column, "hint");
        if ( array_key_exists( "message", $options) ){
            return "<p class='hint'>{$options['message']}</p>";
        }
        return null;
    }

    public function error($model, $column){
        return CHtml::error($model, $column);;
    }
    
    /**
     * Creates the markup to display the hint ot the error associated with a model attribute and returns it.
     * Should not be called from the application directly. If error is present 
     * for the model attribute, the error message is returned, otherwise the hint
     * for the model attribute is returned.
     * 
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @return string returns the markup for the hint or error.
     */
    public function hintOrError($model, $column){
        $hint = $this->hint($model, $column);
        $error = CHtml::error($model, $column);
        return $error ? $error : $hint;
    }

    public function image($model, $attribute) {
        $options = $this->computeElementOptions($model, $attribute, "image");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::tag("img", $htmlOptions );
    }
    
    /**
     * Creates the markup for the label associated with a model attribute and returns it.
     * Should not be called from the application directly. 
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @return string returns the markup for a label.
     */
    public function label($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "label");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeLabel($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup for the label associated with a model attribute and returns it.
     * This method also displays an asterisk next to the label if the model attribute
     * is a required attribute of the model.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @return string returns the markup for a label.
     */
    public function labelEx($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "labelEx");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeLabelEx($model, $attribute, $htmlOptions);
    }
    
    /**
     * Creates the markup of a textfield for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the textfield.
     * @return string returns the markup for a textfield.
     */
    public function textField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "textField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeTextField($model, $attribute, $htmlOptions);
    }
    
    public function integerField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "integerField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $htmlOptions['id'] = array_key_exists( "id", $htmlOptions ) ? $htmlOptions['id'] : CHtml::activeId($model, $attribute);
        $htmlOptions['name'] = array_key_exists( "name", $htmlOptions ) ? $htmlOptions['name'] : CHtml::activeName($model, $attribute);
        $htmlOptions['value'] = $model->$attribute;
        $htmlOptions['type'] = "text";
        
        return Yii::app()->controller->widget("ext.yiigems.widgets.inputs.NumberField", array(
            'htmlOptions' => $htmlOptions,
            'inputType' => 'integer',
        ), true);
    }
    
    public function decimalField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "decimalField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $htmlOptions['id'] = array_key_exists( "id", $htmlOptions ) ? $htmlOptions['id'] : CHtml::activeId($model, $attribute);
        $htmlOptions['name'] = array_key_exists( "name", $htmlOptions ) ? $htmlOptions['name'] : CHtml::activeName($model, $attribute);
        $htmlOptions['value'] = $model->$attribute;
        $htmlOptions['type'] = "text";
        
        return Yii::app()->controller->widget("ext.yiigems.widgets.inputs.NumberField", array(
            'htmlOptions' => $htmlOptions,
            'inputType' => 'decimal',
        ), true);
    }
    
    public function numberField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "numberField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeNumberField($model, $attribute, $htmlOptions);
    }
    
    public function telephoneField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "telephoneField");
        $mask = array_key_exists( "mask", $options ) ? $options["mask"] : "999-999-9999";
        $placeholder = array_key_exists( "placeholder", $options ) ? $options["placeholder"] : "_";
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $htmlOptions['id'] = array_key_exists( "id", $htmlOptions ) ? $htmlOptions['id'] : CHtml::activeId($model, $attribute);
        $htmlOptions['name'] = array_key_exists( "name", $htmlOptions ) ? $htmlOptions['name'] : CHtml::activeName($model, $attribute);
        $htmlOptions['value'] = $model->$attribute;
        $htmlOptions['type'] = "text";
        
        return Yii::app()->controller->widget("ext.yiigems.widgets.inputs.MaskedInputField", array(
            'htmlOptions' => $htmlOptions,
            'mask' => $mask,
            'placeholder' => $placeholder,
        ), true);
    }
    
    public function emailField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "emailField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeEmailField($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a hidden field for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the hidden field.
     * @return string returns the markup for a hidden field.
     */
    public function hiddenField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "hiddenField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeHiddenField($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a password field for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the password field.
     * @return string returns the markup for a password field.
     */
    public function passwordField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "passwordField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activePasswordField($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a textarea for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the textarea.
     * @return string returns the markup for a textarea.
     */
    public function textArea($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "textArea");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeTextArea($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a file upload field for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the file upload field.
     * @return string returns the markup for a file upload field.
     */
    public function fileField($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "fileField");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeFileField($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a radio button for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the radio button.
     * @return string returns the markup for a radio button.
     */
    public function radioButton($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "radioButton");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $displayLabel = array_key_exists("displayLabel", $options) ? $options['displayLabel'] : true;
        $label = CHtml::activeLabel($model, $attribute, array('style'=>'display:inline-block'));
        if ( $displayLabel) return CHtml::activeRadioButton($model, $attribute, $htmlOptions) . " " . $label;
        return CHtml::activeCheckBox($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a checkbox for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the checkbox.
     * @return string returns the markup for a checkbox.
     */
    public function checkBox($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "checkBox");
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        $displayLabel = array_key_exists("displayLabel", $options) ? $options['displayLabel'] : false;
        $label = CHtml::activeLabel($model, $attribute, array('style'=>'display:inline-block'));
        if ( $displayLabel) return CHtml::activeCheckBox($model, $attribute, $htmlOptions) . " " . $label;
        return CHtml::activeCheckBox($model, $attribute, $htmlOptions);
    }

    /**
     * Creates the markup of a dropdown list for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the dropdown list.
     * @return string returns the markup for a dropdown list.
     */
    public function dropdownList($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "dropdownList");
        $data =  array_key_exists( "items", $options ) ? $options["items"] : array();
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeDropDownList($model, $attribute, $data, $htmlOptions);
    }

    /**
     * Creates the markup of a list box for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the list box.
     * @return string returns the markup for a list box.
     */
    public function listBox($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "listBox");
        $data =  array_key_exists( "items", $options ) ? $options["items"] : array();
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        return CHtml::activeListBox($model, $attribute, $data, $htmlOptions);
    }
    
    /**
     * Creates the markup of a check box list for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the check box list.
     * @return string returns the markup for a check box list.
     */
    public function checkBoxList($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "checkBoxList");
        
        $data =  array_key_exists( "items", $options ) ? $options["items"] : array();
        $clearfixContent =  array_key_exists( "clearfixContent", $options ) ? $options["clearfixContent"] : true;
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        
        $defaultLabelOptions =  array('style'=>'display:inline-block');
        $defaultTemplate =  "<span style='float:left;width:30ex;padding:0.5em 0em'>{input}&nbsp;&nbsp;{label}</span>";
        $defaultSeparator =  " ";

        // These are required to put the checkbox and label in the same line
        $htmlOptions['labelOptions']= array_key_exists( "labelOptions", $htmlOptions ) ? $htmlOptions['labelOptions'] : $defaultLabelOptions;
        $htmlOptions['template'] = array_key_exists( "template", $htmlOptions ) ? $htmlOptions['template'] : $defaultTemplate;
        $htmlOptions['separator']= array_key_exists( "separator", $htmlOptions ) ? $htmlOptions['separator'] : $defaultSeparator;
        $markup = CHtml::activeCheckBoxList($model, $attribute, $data, $htmlOptions);
        return $clearfixContent ? "<div class='clearfix'>$markup</div>" : $markup;
    }
    
    /**
     * Creates the markup of a radio button list for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string $column Specifies a model attribute.
     * @param string $htmlOptions Specifies HTML attributes of the radio button list.
     * @return string returns the markup for a radio button list.
     */
    public function radioButtonList($model, $attribute, $options=null) {
        $options = $options ? $options : $this->computeElementOptions($model, $attribute, "radioButtonList");
        
        $data =  array_key_exists( "items", $options ) ? $options["items"] : array();
        $clearfixContent =  array_key_exists( "clearfixContent", $options ) ? $options["clearfixContent"] : true;
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();
        
        $defaultLabelOptions =  array('style'=>'display:inline-block');
        $defaultTemplate =  "<span style='float:left;width:30ex;padding:0.5em 0em'>{input}&nbsp;&nbsp;{label}</span>";
        $defaultSeparator =  " ";
        
        // These are required to put the radiobutton and label in the same line
        $htmlOptions['labelOptions']= array_key_exists( "labelOptions", $htmlOptions ) ? $htmlOptions['labelOptions'] : $defaultLabelOptions;
        $htmlOptions['template'] = array_key_exists( "template", $htmlOptions ) ? $htmlOptions['template'] : $defaultTemplate;
        $htmlOptions['separator']= array_key_exists( "separator", $htmlOptions ) ? $htmlOptions['separator'] : $defaultSeparator;
        $markup = CHtml::activeRadioButtonList($model, $attribute, $data, $htmlOptions);
        return $clearfixContent ? "<div class='clearfix'>$markup</div>" : $markup;
    }
        
    /**
     * Returns the markup for a submit button.
     * @return string The markup for the submit button. 
     */
    public function submitButton(){
        return Yii::app()->controller->widget("ext.yiigems.widgets.buttons.GradientButton", array(
            'buttonType'=>'submit',
            'confirmMessage'=>$this->submitConfirmMessage,
            'label' => $this->submitButtonLabel,
            'iconClass' => $this->submitIconClass,
            'submitHandlerCode' => $this->submitHandlerCode
        ), true);
    }
    
    public function cancelButton(){
        $options = $this->getFormLevelOptions("cancelButton");
        $cancelConfirmMessage = array_key_exists("confirmMessage", $options) ? $options['confirmMessage'] : null;
        $cancelButtonIcon = array_key_exists("iconClass", $options) ? $options['iconClass'] : "icon-remove";
        $cancelButtonLabel = array_key_exists("label", $options) ? $options['label'] : "Cancel";
        $cancelButtonUrl = array_key_exists("url", $options) ? $options['url'] : array('/site/index');
        return Yii::app()->controller->widget("ext.yiigems.widgets.buttons.GradientButton", array(
            'gradient' => 'none',
            'options' => array('style'=>'color:black'),
            'confirmMessage'=>$cancelConfirmMessage,
            'iconClass' => $cancelButtonIcon,
            'label' => $cancelButtonLabel,
            'url' => $cancelButtonUrl
        ), true);
    }
    
    /**
     * Creates the markup of a captcha for a model attribute and returns it.
     * @param object $model Specifies a model.
     * @param string verifyCode Specifies the model attribute for capcha verification.
     * @return string returns the markup for a captcha.
     */
    public function captcha($model, $field='verifyCode' ) {
        if ( !extension_loaded('gd') ) return "";

        return Yii::app()->controller->widget('CCaptcha', array(
            "showRefreshButton"=>true,
            "captchaAction"=>"site/captcha",
            "imageOptions"=>array('style'=>'vertical-align:middle'),
            "buttonOptions"=>array('style'=>'margin-left:10px'),
        ), true);
    }
    
    /**
     * @return string The hint string to be displayed for captcha.
     */
    public function captchaHints() {
        return <<<EOT
        <p class="hint">
            Please enter the letters as they are shown in the image above.
            <br/>
            Letters are not case-sensitive.
        </p>
EOT;
    }
    
    /**
     * Returns the markup for terms and condition row in the form.
     * @param object $model specifies a mode.
     * @param string $column the column indicating whether terms and condition is accepted.
     * @return string returns the markup for terms and condition field in the form.
     */
    public function termsAndCondition( $model, $column ) {
        $options = $this->computeElementOptions($model, $column, "termsAndCondition");
        $text = array_key_exists('text', $options) ? $options["text"] : "I accept terms and Condition";
        $viewLabel = array_key_exists('viewLabel', $options) ? $options["viewLabel"] : "View";
        $targetUrl = array_key_exists('targetUrl', $options) ? $options["targetUrl"] : "javascript:void(0)";
        $htmlOptions = array_key_exists( "htmlOptions", $options ) ? $options["htmlOptions"] : array();

        $formField = CHtml::activeCheckBox($model,$column, $htmlOptions);
        $linkTag = CHtml::link( $viewLabel, $targetUrl, array("target"=>"_blank") );
        return $formField . "<span style='margin:0em 0.5em'>$text</span>". $linkTag;
    }
    
    //==========================================================================
    // text display fields
    //==========================================================================
    public function markup($markup) {
        $args = func_get_args();
        return array_pop($args);
    }
    
    /**
     * Creates the markup for a simple message and returns the same.
     * The message is wrapped in a span element with class set to 'note'
     * @param string $message The message string.
     * @return string The HTML markup for the message. 
     */
    public function simpleMessage($message) {
        return "<span class='note'>$message</span>";
    }
    
    /**
     * Creates the markup for a info message and retruns the same.
     * The message is created using the Message widget.
     * @param string $message The message string.
     * @return string The HTML markup for the message.
     */
    public function message($message) {
        return $this->widget("ext.yiigems.widgets.message.Message", array(
            'content'=>$message,
            'scenario'=>"formNote",
        ), true);
    }

    /**
     * @return string returns the empty content for a cell.
     */
    public function emptyContent(){
        return "";
    }
    /**
     * @return string The markup for a horizontal ruler.
     */
    public function horzRule() {
        return "<div class='horzRule' style='$this->submitSectionRulerStyle'></div>";
    }

    /**
     * @return string returns the markup for required field note.
     */
    public function asteriskedFieldsNote() {
        return "<p class='note'>Fields marked with <span class='required'>*</span> are required.</p>";
    }
    
    // =========================================================================
    // Metghods to select entitities
    // =========================================================================
    public function entitySelectField($model, $column){
        $options = $this->computeElementOptions($model, $column, "entitySelectField");
        $options['model'] = $model;
        $options['column'] = $column;
        return Yii::app()->controller->widget( "ext.yiigems.widgets.entitySelection.EntitySelectionWidget", $options, true );
    }
    
    //==================================================================================================================
    // Methods to get options for form fields
    //==================================================================================================================
    public function computeElementOptions($model, $column, $elementName){
        $formLevelOptions = $this->getFormLevelOptions( $elementName );
        $fieldLevelOptions = $this->getFieldLevelOptions( $model, $column, $elementName );
        $result = array_merge($formLevelOptions, $fieldLevelOptions );

        $mergedArrays = array( "htmlOptions", "inputFieldOptions");
        foreach ($mergedArrays as $name) {
            if (array_key_exists($name, $formLevelOptions) && array_key_exists($name, $fieldLevelOptions)) {
                $result[$name] = ComponentUtil::mergeHtmlOptions($formLevelOptions[$name], $fieldLevelOptions[$name]);
            }
        }
        return $result;
    }

    public function getFormLevelOptions($elementName){
        foreach( $this->formConfig as $key=>$item ){
            if ( $key == $elementName ){
                return $item;
            }
        }
        return array();
    }
    
//    public function getFieldLevelOptions($model, $column, $elementName){
//        $allOptions =  array();
//        
//        foreach( $this->itemsConfig as $item ){
//            $columns = explode( ",", $item[1] );
//            $columns = array_map("trim", $columns);
//            if ( $item[0] === $model && in_array($column, $columns)){
//                $allOptions[] = array_key_exists($elementName, $item[2]) ? $item[2][$elementName] :  array();
//            }
//        }
//        $result = array();
//        foreach( $allOptions as $opts ){
//            $result = array_merge($result, $opts);
//        }
//        return $result;
//    }

    private function getFieldLevelOptions($model, $column, $elementName){
        foreach( $this->itemsConfig as $item ){
            if ( $item[0] === $model && $item[1] === $column ){
                return array_key_exists($elementName, $item[2]) ? $item[2][$elementName] :  array();
            }
        }
        return array();
    }

    //==========================================================================
    // Private utility methods
    //==========================================================================
    /**
     * @return string the image tag for the help icon displayed on the form. 
     */
    public function getHelpImageTag($id){
        $assetPath = $this->getAssetPublishPath("form.css");
        $imagePath = $assetPath . "/images/help.png";
        return "<image id='$id' src='$imagePath' alt='Help' style='vertical-align: middle;margin-left:0.5em;'/>";
    }
}

?>
