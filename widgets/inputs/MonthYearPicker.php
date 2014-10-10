<?php

/**
 * Description of MonthPicker
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.inputs
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class MonthYearPicker extends AppWidget {
    public $containerTag = "div";
    public $containerOptions =  array();
    
    /** HTML options for the input element */
    public $htmlOptions =  array();
    
    public $iconTrigger = false;
    public $iconClass = "icon-chevron-sign-down";
    
    /** The default options for the title box in the popup */
    public $titleBoxOptions = array();
    
    /** Whether to display a close button on the title box popup */
    public $allowClose = false;
    
    /** The default options for the buttons in the popup */
    public $buttonOptions = array();
    
    /** The z index associated with the popup */
    public $popupZindex = 100;
    
    /** Whether to display and allow selecting a month */
    public $allowMonthSelection = true;
    
    /** The selected mnth as a string. Defaults to current month */
    public $selectedMonth;
    
    /** The selected month as a number. Defaults to current year */
    public $selectedMonthNumber;
    
    /** Number of months didplayed per line in the popup **/
    public $monthsPerRow = 3;
    
    /** Display short month names in the user interface */
    public $useShortMonthNames = true;
    
    /** The short month names */
    public $shortMonthNames = array( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug" , "Sep", "Oct", "Nov", "Dec" );
    
    /** The long versions of the month names */
    public $longMonthNames = array( 
        "January", "February", "March", "April", "May", "June", 
        "July", "August" , "September", "October", "November", "December" 
    );
    
    /** A JQuery selector which will be updated with the selected month value */
    public $monthFieldSelector;
    public $monthNumberFieldSelector;
    
    
    /** Whether to display and allow selecting a year */
    public $allowYearSelection = true;
    
    /** The currently selected year. Defaults to current year */
    public $selectedYear;
    
    /** The year at which the selection starts. Defaults to current year */
    public $startYear;
    
    /** The year at which selection ends. By default $endYear = $startYear + 19 */
    public $endYear;
    
    /** Number of year buttons displayed per row on the popup window */
    public $yearsPerRow = 5;
    
    /** A JQuery selector which will be updated with the selected year value */
    public $yearFieldSelector;
    
    /** format of the displayed string. possible tokens are month, month-number and year */
    public $format = "{month}, {year}";
    
    public $selectedValue;
    
    /** The id of the popup element */
    private $popupId;
    
    /** The id of the icon displayed mext to the text field when triggered by icon */
    private $iconId;
    
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        JQueryUI::registerYiiJQueryUIResources();
        $this->addYiiGemsCommonCss();
        $this->addFontAwesomeCss();
        $this->addAssetInfo( "monthYearPicker.css", dirname(__FILE__) . "/assets" );
        $this->addAssetInfo( "monthYearPicker.js", dirname(__FILE__) . "/assets" );
    }
    
    protected function setMemberDefaults() {
        parent::setMemberDefaults();
        
        // Set ids if they are not given
        if(!$this->id) $this->id = UniqId::get("mp-");
        if(!$this->popupId) $this->popupId = UniqId::get("mpp-");
        if(!$this->iconId) $this->iconId = UniqId::get("mpi-");
        
        // Make sure the input is a text and set its value
        if (!array_key_exists("type", $this->htmlOptions)){
            $this->htmlOptions['type'] = "text";
            if ( $this->selectedValue ){
                $this->htmlOptions['value'] = $this->selectedValue;
            }
        }
        
        // If buttonGradient is not given default to that from titlebox
        if (!array_key_exists("gradient", $this->buttonOptions)){
            if (array_key_exists("headerGradient", $this->titleBoxOptions)){
                $this->buttonOptions['gradient'] = $this->titleBoxOptions['headerGradient'];
            }
        }
        
        // Set startYear and endYear if not set
        $this->startYear = $this->startYear ? $this->startYear : date('Y');
        $this->endYear = $this->endYear ? $this->endYear : $this->startYear + 19;
        
        // make sure endYear-startYear < 50
        if ($this->endYear - $this->startYear >  49 ){
           $this->endYear = $this->startYear + 49; 
        }
        
        // If selected month and year not set deault to current
        if (!$this->selectedMonthNumber && !$this->selectedMonth){
            $this->selectedMonthNumber = date('n');
            $this->selectedMonth = $this->useShortMonthNames ? $this->shortMonthNames[$this->selectedMonthNumber-1]
                                 : $this->longMonthNames[$this->selectedMonthNumber-1];
        }
        if (!$this->selectedYear){
            $this->selectedYear = date('Y');
        }
    }
    
    public function init() {
        parent::init();
        $this->registerAssets();
        
        $options = $this->getContainerOptions();
        $this->id = $options['id'];
        echo CHtml::openTag( $this->containerTag, $options );
        
        $options = $this->getInputOptions();
        echo CHtml::tag("input", $this->getInputOptions());
        
        if ($this->iconTrigger ){
            echo "<span class='$this->iconClass triggerIcon'></span>";
        }
        $this->renderPopup();
        echo CHtml::closeTag( $this->containerTag );
    }
    
    public function renderPopup(){
        echo CHtml::openTag("div",  array(
            'id' => $this->popupId,
            'style'=>"position:absolute;display:none;z-index:$this->popupZindex")
        );
        $this->beginWidget("ext.yiigems.widgets.titleBox.TitleBox", $this->getTitleBoxOptions());
        $this->renderContent();
        $this->endWidget();
        echo CHtml::closeTag("div" );
    }
    
    public function getTitleBoxOptions(){
        $options = array(
            'titleText' => $this->getPopupTitle(),
            'leftIconClass' => "icon-calendar pull-left",
            'rightIconClass' => $this->allowClose ? 'closeIcon icon-remove pull-right' : null,
            'headerRoundStyle' => 'small_round_top',
            'containerRoundStyle' => 'small_round',
            'contentRoundStyle' => 'small_round_bottom',
            'contentOptions' => array('style'=>'background:white;border-style:solid;border-width:0.2em')
        );
        return array_merge($options, $this->titleBoxOptions);
    }
    
    public function renderContent(){
        if( $this->allowMonthSelection && !$this->allowYearSelection ){
            $this->renderMonthsTable();
        }
        else if( !$this->allowMonthSelection && $this->allowYearSelection ){
            $this->renderYearsTable();
        }
        else {
            $table = $this->beginWidget("ext.yiigems.widgets.table.HtmlTable", array(
                'cellStyle'=>"padding: 0.2em;vertical-align:top"
            ));

            // Months Label
            $options = array('style' => 'margin-bottom:0em;text-align:center');
            $table->startContent();
            TitleUtil::titleHeader("Months", array('options'=>$options));
            $table->endContent();

            // Separator
            $table->addContent(UIHelper::horizontalStrut("20px"));

            // Years Label
            $table->startContent();
            TitleUtil::titleHeader("Years", array('options'=>$options) );
            $table->endContent(true);

            // Months table
            $table->startContent();
            $this->renderMonthsTable();
            $table->endContent();

            // placeholder separator
            $table->addContent("");

            // Years Table
            $table->startContent();
            $this->renderYearsTable();
            $table->endContent(true);

            $this->endWidget();
        }
    }
    
    public function renderMonthsTable(){
        $table = $this->beginWidget("ext.yiigems.widgets.table.HtmlTable", array());
        $monthNames = $this->getMonthNames();
        $width = $this->useShortMonthNames ? "5ex" : "10ex";
        foreach( $monthNames as $index => $monthName ){
            $options = array(
                'addClass' => 'month',
                'label' => $monthName,
                'options' => array('style'=>"width:$width;padding:0.1em", 'data-month'=>$monthName, 'data-month-number'=>$index+1),  
            );
            $options = ComponentUtil::mergeHtmlOptions($options, $this->buttonOptions );
            $wrap = ($index+1) % $this->monthsPerRow == 0;
            $table->addWidget("ext.yiigems.widgets.buttons.GradientButton", $options, $wrap );
        }
        $this->endWidget();
    }
    
    public function renderYearsTable(){
        $table = $this->beginWidget("ext.yiigems.widgets.table.HtmlTable", array());
        for( $year = $this->startYear; $year <= $this->endYear; $year++ ){
            $index = $year - $this->startYear;
            $options = array(
                'addClass' => 'year',
                'label' => $year,
                'options' => array('style'=>"width:6ex;padding:0.1em", 'data-year'=>$year),
            );
            $options = ComponentUtil::mergeHtmlOptions($options, $this->buttonOptions );
            $wrap = ($index+1) % $this->yearsPerRow == 0;
            $table->addWidget("ext.yiigems.widgets.buttons.GradientButton", $options, $wrap );
        }
        $this->endWidget();
    }
    
    public function getContainerOptions(){
        $options =  array(
            'id' => $this->id,
            'class'=>'monthYearPicker',
            'style'=>'position:relative',
        );
        return ComponentUtil::mergeHtmlOptions($options, $this->containerOptions);
    }
    
    public function getInputOptions(){
        $options = ComponentUtil::computeHtmlOptions(array(
            'addClass' => $this->addClass,
            'class' => 'monthPicker',
        ));
        return ComponentUtil::mergeHtmlOptions($options, $this->htmlOptions);
    }
    
    public function run() {
        $monthSelection = $this->allowMonthSelection ? "true" : "false";
        $yearSelection = $this->allowYearSelection ? "true" : "false";
        
        Yii::app()->clientScript->registerScript( UniqId::get('mp-'), "
            \$('#$this->id').monthPicker({
                popupId: '$this->popupId',
                iconId: '$this->iconId',
                format: '$this->format',
                selectedMonth: '$this->selectedMonth',
                selectedMonthNumber: $this->selectedMonthNumber,
                selectedYear: $this->selectedYear,
                allowMonthSelection: $monthSelection,
                allowYearSelection: $yearSelection,
                monthFieldSelector: '$this->monthFieldSelector',
                monthNumberSelector: '$this->monthNumberFieldSelector',
                yearFieldSelector: '$this->yearFieldSelector'
            });
        ");
    }
    
    public function getPopupTitle(){
        if ( $this->allowMonthSelection && !$this->allowYearSelection ){
            return "Select a Month";
        }
        else if ( !$this->allowMonthSelection && $this->allowYearSelection ){
            return "Select a Year";
        }
        else {
            return "Select Month and Year";
        }
    }
    
    public function getMonthNames(){
        return $this->useShortMonthNames ? $this->shortMonthNames : $this->longMonthNames;
    }
}

?>
