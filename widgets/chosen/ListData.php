<?php

/**
 * Description of ListData
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.chosen
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */

class ListData {
   public $options = array(
//       array('group'=> "group1", 'value'=> "abc", 'displayValue'=> "Abc", 'disabled'=> false, 'selected'> false);
   );
   
   public function normalizeOptions(){
       $listValues = array();
       foreach( $this->options as $key => $opt ){
           $opt = $this->normalizeOption($key, $opt);
           if ( $opt ) $listValues[] = $opt;
       }
       $this->options = $listValues;
   }
   
   public function normalizeOption( $key, $option ){
       if ( is_string( $option ) ){
           $value = is_string($key) ? $key : $option;
           return array( 'group'=> null, 'value' => $value, 'displayValue' => $option );
       }
       else if ( is_array($option) ){
           if ( !array_key_exists('group', $option ) ) $option['group'] = null;
           if ( !array_key_exists('displayValue', $option ) ) $option['displayValue'] = $option['value'];
           return $option;
       }
   }
   
   public function getGroups() {
        $groups = array();
        foreach ($this->options as $option) {
            $found = false;
            foreach ($groups as &$group) {
                if ($group['name'] == $option['group']) {
                    $found = true;
                    $group['options'][] = $option;
                    break;
                }
            }
            if (!$found ){
               $groups[] = array(
                   'name' => $option['group'],
                   'options' => array( $option )
               ); 
            }
        }
        return $groups;
    }
    
    public function getOptionsMarkup(){
        $groups = $this->getGroups();
        
        $markup = "";
        foreach( $groups as $group ){
            if ( array_key_exists('name', $group) && $group['name']){
                $markup .= CHtml::openTag( "optgroup",  array('label' => $group['name']) );
            }
            foreach( $group['options'] as $option ){
                if ( !$option['value'] && !$option['displayValue'] ) return;
                $markup .= CHtml::openTag( "option", array(
                    'value' => $option['value'],
                    'selected' => array_key_exists('selected', $option) ? $option['selected'] : false,
                    'disabled' => array_key_exists('disabled', $option) ? $option['disabled'] : false,
                ));
                $markup .= $option['displayValue'];
                $markup .= CHtml::closeTag( "option" );
            }
            if ( array_key_exists('name', $group) && $group['name'] ){
                $markup .= CHtml::closetag( "optgroup" );
            }
        }
        return $markup;
    }
    
    public function clearSelection( $value, $selected ){
        foreach( $this->options as &$option ){
            $option['selected'] = false;
        }
    }
    
    public function setSelected( $value, $selected ){
        foreach( $this->options as &$option ){
            if ( $option['value'] == $value){
                $option['selected'] = $selected;
                break;
            }
        }
    }
    
    public function setDisabled( $value, $disabled ){
        foreach( $this->options as &$option ){
            if ( $option['value'] == $value){
                $option['disabled'] = $disabled;
                break;
            }
        }
    }
    
//    public function setGroupDisabled( $groupName, $disabled ){
//        $groups = $this->getGroups();
//        $group = $this->findGroup($groupName, $groups);
//        
//        foreach( $group['options'] as &$option ){
//            $option['disabled'] = $disabled;
//        }
//    }
}
?>