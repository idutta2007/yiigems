<?php

/**
 * Description of EditableColumn
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.yii
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 * 
 * An example of creating the DataColumn will be
 * new EditableColumn(
 *    'name' = > 'date_of_birth',
 *    'controlType' => 'datePicker',
 * )
 * new EditableColumn(
 *    'name' = > 'favorite_color',
 *    'editor' => array(
 *        'controlType' => 'chosen',
 *        'listData' => array( 'red', 'green', 'blue'
 *    )
 * )
 * 
 */

Yii::import('ext.yiigems.widgets.yii.GridCellEditor');
Yii::import('zii.widgets.grid.CDataColumn');

class EditableColumn extends CDataColumn {
    /** The options passed to the cell editor */
    public $editor = array();
    
    //public $editorCreated = false;
    public $scriptRegistered = false;
    
    public function init(){
        if (!$this->name) {
            throw new CHttpException('Name of the column must be provided');
        }
        parent::init();
        
        // create the editor
        $this->editor['gridId'] = $this->grid->id;
        $this->editor['attribute'] = $this->name;
        if (!array_key_exists("controlType", $this->editor)) {
            $this->editor['controlType'] = 'textField';
        }
        $this->editor = Yii::app()->controller->widget( "ext.yiigems.widgets.yii.EditableField", $this->editor );
    }
    
    protected function renderDataCellContent($row, $data){
        // Create the ediotor if it is not created already
//        if (!$this->editorCreated ){
//            $this->editor['gridId'] = $this->grid->id;
//            $this->editor['model'] = $data;
//            $this->editor['attribute'] = $this->name;
//            if (!array_key_exists("controlType", $this->editor)) {
//                $this->editor['controlType'] = 'textField';
//            }
//            
//            // render the popup only for non-ajx request.
//            $this->editor = Yii::app()->controller->widget( "ext.yiigems.widgets.yii.EditableField", $this->editor );
//            $this->editorCreated = true;
//        }
        
        // Set the link Text and render the link
        $this->editor->linkText = $this->getLinkText($row, $data);
        $this->editor->model = $data;
        $this->editor->renderLink();
    }
    
    public function getLinkText($row, $data) {
        if ( $data->{$this->name} !== null ){
            ob_start();
            parent::renderDataCellContent($row, $data);
            return ob_get_clean();
        }
        else {
            return null;
        }
    }
}
?>
