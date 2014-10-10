<?php

/**
 * An widget to lay out objects in a table.
 * The HTMLTable is designed to add widgets in a tabular layout. It also can be used to layout  any HTML contents in
 * tabular form. It provides convenient methods like startRow, endRow, startCell and endCell.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.table
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */
Yii::import("ext.yiigems.widgets.common.AppWidget");

class HtmlTable extends AppWidget {
    /**
     * @var string the style for each cell in the table
     */
    public $cellStyle = "padding: 0.5em;vertical-align:middle";

    /**
     * @var array HTML options for the table.
     */
    public $tableOptions = array();

    /**
     * @var bool whether a row has been started
     */
    private $rowStarted = false;

    /**
     * @var bool flag indicating whether a cell has been started.
     */
    private $cellStarted = false;

    /**
     * Initializes the widget by producing the table start markups.
     */
    public function init(){
        parent::init();
        $this->registerAssets();
        
        echo CHtml::openTag("table", $this->tableOptions);
    }

    /**
     * Starts a new row in the table.
     * @throws CHttpException if row was already started
     */
    public function startRow(){
        if ( $this->rowStarted ){
            throw new CHttpException( "Row was already started" );
        }
        echo CHtml::openTag("tr", array());
        $this->rowStarted = true;
    }

    /**
     * Ends the current row.
     * @throws CHttpException if no row was started.
     */
    public function endRow(){
        if ( !$this->rowStarted ){
            throw new CHttpException( "Row was not started" );
        }
        echo CHtml::closeTag("tr", array());
        $this->rowStarted = false;
    }

    /**
     * Starts a new cell in the current row.
     * @throws CHttpException if a cell was already started
     */
    public function startCell(){
        if ( $this->cellStarted ){
            throw new CHttpException( "Cell was already started" );
        }
        echo CHtml::openTag("td", array('style'=>$this->cellStyle));
        $this->cellStarted = true;
    }

    /**
     * End the current cell.
     * @throws CHttpException if no cell was started
     */
    public function endCell(){
        if ( !$this->cellStarted ){
            throw new CHttpException( "Cell was not started" );
        }
        echo CHtml::closeTag("td");
        $this->cellStarted = false;
    }

    /**
     * @param $content the content to be added inside a cell.
     * @param bool $wrap specifies whether the current row needs to be ended.
     */
    public function addContent( $content, $wrap=false ){
        if(!$this->rowStarted) $this->startRow ();
        
        $this->startCell();
        echo $content;
        $this->endCell();
        
        if( $wrap ) $this->endRow();
    }
    
    public function startContent(){
        if(!$this->rowStarted) $this->startRow ();
        $this->startCell();
    }
    
    public function endContent($wrap=false){
        if ( !$this->rowStarted ){
            throw new CHttpException( "Row was not started" );
        }
        if ( !$this->cellStarted ){
            throw new CHttpException( "Cell was not started" );
        }
        $this->endCell();
        if( $wrap ) $this->endRow();
    }
    
    public function addContents( $contents, $wrap=false ){
        if(!$this->rowStarted) $this->startRow ();
        foreach( $contents as $content ){
            $this->startCell();
            echo $content;
            $this->endCell();
        }
        if( $wrap ) $this->endRow();
    }

    /**
     * @param $widgetClass specifies a widget by its fully qualified path name.
     * @param $options the options for the widget.
     * @param bool $wrap specifies whether the current row needs to be ended.
     */
    public function addWidget( $widgetClass, $options, $wrap=false ){
        if(!$this->rowStarted) $this->startRow ();
        
        $this->startCell();
        $con = Yii::app()->controller;
        $con->widget($widgetClass, $options);
        $this->endCell();
        
        if( $wrap ) $this->endRow();
    }

    /**
     * Produces the end tag for the table.
     */
    public function run(){
        if($this->rowStarted) $this->endRow();
        echo CHtml::closeTag("table");
    }
}

?>
