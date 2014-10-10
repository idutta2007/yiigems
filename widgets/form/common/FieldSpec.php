<?php

/**
 * The class that defines how an attribute from a CModel is laid out in a form.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 * 
 * [labelEx wrap][textField/popupHelp/hintOrError wrap]
 */

Yii::import( "ext.yiigems.widgets.form.common.CellSpec");

class FieldSpec {
    /**
     * @var array the list of cell specification for the field or attribute. 
     */
    public $cellSpecs = array();
    
    /**
     * Parses a string to get the cell specifications of an attribute.
     * @param string $spec specifies the cells occupied an attribute.
     */
    public function parse( $spec ){
        $tokens = preg_split( "%[\[\]]+%", $spec);
        foreach ($tokens as $token) {
            if ($token) {
                $cell = new CellSpec();
                $cell->parse($token);
                $this->cellSpecs[] = $cell;
            }
        }
    }
}

?>
