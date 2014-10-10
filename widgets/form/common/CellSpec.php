<?php

/**
 * CellSpec class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form.common
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 * 
 * Example: "textField/popupHelp/hintOrError wrap span 3 1"
 */
class CellSpec {
    //The components which will be placed in this cell
    public $components = array();
    
    // Whether layout should wrap after laing out this cell
    public $wrap = false;
    
    // spans of the cell
    public $rowspan = 1;
    public $colspan = 1;
    
    public function parse($spec){
        $tokens = explode( " ", $spec);
        
        // Get the list of components
        if (count($tokens)){
            $list = array_shift($tokens);
            $this->components = explode('/', $list);
        }
        
        while(count($tokens)){
            $token = array_shift($tokens);
            if ($token == "wrap" ){
                $this->wrap = true;
            }
            else if ($token == "span") {
                $this->colspan = 0;
                if (count($tokens)) {
                    // Get the column span
                    $token = array_shift($tokens);
                    if (is_numeric($token)) {
                        $this->colspan = (int) $token;
                        
                        // Get the row span
                        if (count($tokens)) {
                            $token = array_shift($tokens);
                            if (is_numeric($token)) {
                                $this->rowspan = (int) $token;
                            } 
                            else {
                                array_unshift($tokens, $token);
                            }
                        }
                    } 
                    else {
                        array_unshift($tokens, $token);
                    }
                }
            }
        }
    }
}

?>
