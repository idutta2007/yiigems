<?php

/**
 * Description of FormConfigUtil
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.form.common
 * @link http://www.logictowers.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class FormConfigUtil {
    public function normalizeFormConfig($formConfig){
        // create an integer based array from $formConfig of the form
        // $offset => array( element(s), element(s)Config )
        $configs = array();
        foreach ($formConfig as $key => $config) {
            $configs[] = array($key, $config );
        }
        
        // replace each multi-element entry with individual entries in the same place
        while(($index = $this->getFirstMultiElementConfig($configs)) !== false ){
            $this->normalizeMultiElementIndex($index, $configs);
        }
        
        // Get the list of distinct elements
        $elements = $this->getElements($configs);
        
        // Merge each element configs
        $result = array();
        foreach( $elements as $element ){
            $elementConfigs = $this->getElementConfigs($element, $configs);
            $result[$element] = $this->mergeElementConfigs($elementConfigs);
        }
        return $result;
    }
    
    /**
     * Each value in $configs array is of the form 
     * array( element(s), element(s)Config )
     */
    public function getFirstMultiElementConfig($configs){
        foreach($configs as $index => $config ){
            $elements = preg_split("/[,\s]/", $config[0], -1, PREG_SPLIT_NO_EMPTY);
            if ( count($elements) > 1 ) return $index;
        }
        return false;
    }
    
    public function normalizeMultiElementIndex($index, &$configs){
        $config = $configs[$index];
        $elements = preg_split("/[,\s]/", $config[0], -1, PREG_SPLIT_NO_EMPTY);
        $inserted = array();
        foreach($elements as $element){
            $inserted[] = array($element, $config[1]);
        }
        array_splice($configs, $index, 1, $inserted );
    }
    
    public function getElements($configs){
        $elements = array();
        foreach( $configs as $config ){
            if (!in_array($config[0], $elements)){
                $elements[] = $config[0];
            }
        }
        return $elements;
    }
    
    public function getElementConfigs($element, $configs){
        $result = array();
        foreach( $configs as $config ){
            if ( $config[0] === $element ){
                $result[] = $config[1];
            }
        }
        return $result;
    }
    
    public function mergeElementConfigs($elementConfigs){
        $result = array();
        foreach( $elementConfigs as $elementConfig ){
            $result = array_merge($result, $elementConfig);
        }
        return $result;
    }
    
    /* =======================================================================*/
    public function normalizeItemConfigs($itemConfigs){
        // replace each multi-column entry with individual entry in the same place
        while( ($index = $this->getFirstMultiColumnIndex($itemConfigs)) !== null ){
            $this->normalizeMultiColumnIndex($index, $itemConfigs);
        }
        
        // Merge configs for same column
        $columns = $this->getColumns($itemConfigs);
        foreach( $columns as $column ){
            $columnConfigs = $this->getColumnConfigs($column[0], $column[1], $itemConfigs);
            $this->removeColumnConfigs($column[0], $column[1], $itemConfigs);
            $itemConfigs[] = array($column[0], $column[1], $this->mergeColumnConfigs($columnConfigs));
        }
        return $itemConfigs;
    }
    
    function getFirstMultiColumnIndex($itemConfigs){
        foreach ($itemConfigs as $index => $itemConfig) {
            $columns = preg_split("/[,\s]/", $itemConfig[1], -1, PREG_SPLIT_NO_EMPTY);
            if (count($columns) > 1) {
                return $index;
            }
        }
        return null;
    }
    
    /**
     * Delete the multi-column config and add individual column configs
     * in the same location where the multi-column config appeared
     */
    function normalizeMultiColumnIndex($index, &$itemConfigs){
        $config = $itemConfigs[$index];
        $columns = preg_split("/[,\s]/", $config[1], -1, PREG_SPLIT_NO_EMPTY);
        $inserted = array();
        foreach($columns as $column){
            $inserted[] = array($config[0], $column, $config[2] );
        }
        array_splice($itemConfigs, $index, 1, $inserted );
    }
    
    function mergeColumnConfigs($configs){
        $result = array();
        foreach( $configs as $config ){
            $result = array_merge($result, $config);
        }
        return $result;
    }
    
    function getColumns($itemConfigs) {
        $result = array();
        foreach ($itemConfigs as $itemConfig) {
            if (!$this->hasColumn($itemConfig[0], $itemConfig[1], $result)) {
                $result[] = array($itemConfig[0], $itemConfig[1]);
            }
        }
        return $result;
    }
    
    function hasColumn($model, $column, $list) {
        foreach ($list as $item) {
            if ($item[0] === $model && $item[1] === $column) {
                return true;
            }
        }
        return false;
    }
    
    function getColumnConfigs($model, $column, $itemConfigs) {
        $result = array();
        foreach ($itemConfigs as $itemConfig) {
            if ($itemConfig[0] === $model && $itemConfig[1] === $column) {
                $result[] = $itemConfig[2];
            }
        }
        return $result;
    }
    
    function removeColumnConfigs($model, $column, &$itemConfigs) {
        $indices = array();
        foreach($itemConfigs as $index=>$itemConfig){
            if ( $itemConfig[0] === $model && $itemConfig[1] === $column ){
                $indices[] = $index;
            }
        }
        foreach( $indices as $index ){
            unset($itemConfigs[$index]);
        }
    }
}

?>
