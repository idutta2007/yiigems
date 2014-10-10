<?php

/**
 * Widget to create search form for CModel (CActiveRecord or CFromModel) objects.
 * The ModelSearchForm is derived from ActiveModelForm to create a widget that
 * facilitate creating search forms for mostly CActiveRecord objects. The process of
 * creating the search form is exactly same as creating an ActiveModelForm widget
 * except that you also need to provide the id of the CGridView to be updated 
 * as a result of this search.
 *
 * Here is an example of a search form which assumes that CGridView with id "studentGrid" exists.
 * Submitting the form will execute the javascript method $.fn.yiiGridView.update with the id of
 * the grid to update the same.
 *
 * <pre>
 *
 * $form = $this->beginWidget("ext.yiigems.widgets.form.ModelSearchForm", array(
 *   'id'=>$formId,
 *   'gridId'=>"studentGrid",
 *   'items' => array(
 *      array( $model, "id", array(
 *         'fieldOptions' => array('size' => 5, 'maxlength' => 10),
 *      )),
 *      array( $model, "first_name", array(
 *         'fieldOptions' => array('size' => 20, 'maxlength' => 128),
 *      )),
 *      array( $model, "last_name", array(
 *         'fieldOptions' => array('size' => 20, 'maxlength' => 128),
 *      )),
 *      array( $model, "address_line1", array(
 *         'fieldOptions' => array('size' => 40, 'maxlength' => 128),
 *      )),
 *      array( $model, "address_line2", array(
 *         'fieldOptions' => array('size' => 40, 'maxlength' => 128),
 *      )),
 *      array( $model, "city", array(
 *         'fieldOptions' => array('size' => 40, 'maxlength' => 128),
 *      )),
 *      array( $model, "state", array(
 *         'fieldOptions' => array('size' => 40, 'maxlength' => 128),
 *      )),
 *      array( $model, "zip", array(
 *         'fieldOptions' => array('size' => 6, 'maxlength' => 128),
 *      )),
 *   )
 * ));
 *
 * $form->startSection( "*", "*"  );
 * $form->add( $model, "first_name", "[labelEx/textField/hintOrError]");
 * $form->add( $model, "last_name", "[labelEx/textField/hintOrError wrap]");
 * $form->add( $model, "address_line1", "[labelEx/textField/hintOrError]");
 * $form->add( $model, "address_line2", "[labelEx/textField/hintOrError wrap]");
 * $form->add( $model, "state", "[labelEx/textField/hintOrError]");
 * $form->add( $model, "city", "[labelEx/textField/hintOrError wrap]");
 * $form->add( $model, "zip", "[labelEx/textField/hintOrError wrap]");
 * $form->endSection();
 *
 * $form->submitButtonSection( "[submitButton wrap]");
 *
 * $this->endWidget();
 * </pre>
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.form.ActiveModelForm");
Yii::import("ext.yiigems.widgets.form.ModelSearchFormDefaults");

class ModelSearchForm extends ActiveModelForm {
    /**
     * The search form uses this id to update the grid after a search is completed. 
     */
    public $gridId = null;
    
    /**
     * The search form uses this id to update the listView after a search is completed. 
     */
    public $listId = null;
    
    public $submitButtonLabel = "Search";
    
    /**
     * Sets the values of widget properties to default values.
     * @see AppWidget::setMemberDefaults
     */
    protected function setMemberDefaults(){
        parent::setMemberDefaults();
        if ( !$this->containerOptions) $this->containerOptions = ModelSearchFormDefaults::$containerOptions;
        $this->id = $this->id ? $this->id : UniqId::get("form-");
    }
    
    /**
     * Initializes this widget.
     * @see CWidget::init
     */
    public function init(){
        $showLabel = "Show Search Form";
        $hideLabel = "Hide Search Form";
        $this->toggleButton($showLabel, $hideLabel, "#$this->id" );
        echo UIHelper::clearBoth("5px");
        
        if ($this->gridId){
            $this->registerGridUpdateScript("#$this->id",  $this->gridId);
        }
        
        if ($this->listId){
            $this->registerListUpdateScript("#$this->id",  $this->listId);
        }
        
        parent::init();
    }
    
    public function labelExCell( $model, $column, $rowspan=1, $colspan=1 ){
        return $this->labelCell( $model, $column, $rowspan, $colspan );
    }
    
    public function toggleButton($showLabel, $hideLabel, $formSelector ){
        $linkId = UniqId::get("lnk-");
        echo CHtml::openTag("a", array(
            'id'=>$linkId,
            'href'=>'javascript:void(0)',
        ));
        echo $hideLabel;
        echo CHtml::closeTag("a");
        Yii::app()->clientScript->registerScript( "sf-" . UniqId::get("scr-") , "
            $('#$linkId').click(function(){
                if ($('$formSelector').parent().is(':visible') ){
                    $('$formSelector').parent().slideToggle(200, 'swing');
                    $(this).text('$showLabel');
                }
                else {
                    $('$formSelector').parent().slideToggle(200, 'swing');
                    $(this).text('$hideLabel' );
                }
            });  
        ");
    }
    
    public static function registerGridUpdateScript($formSelector, $gridId){
        Yii::app()->clientScript->registerScript( "sf-" . UniqId::get("scr-") , "
            $('$formSelector').submit(function(){
                $.fn.yiiGridView.update('$gridId', {
                     data: $(this).serialize()
                });
                return false;
            });
        ");
    }
    
    public static function registerListUpdateScript($formSelector, $listId){
        Yii::app()->clientScript->registerScript( "sf-" . UniqId::get("scr-") , "
            $('$formSelector').submit(function(){
                $.fn.yiiListView.update('$listId', {
                     data: $(this).serialize()
                });
                return false;
            });
        ");
    }
}

?>
