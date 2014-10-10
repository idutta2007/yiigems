<?php

/**
 * Description of EntitySelectionDialog
 *
 * @author Indra K Dutta <indra_dutta@logictowers.com>
 * @version 1.0
 * @package ext.yiigems.widgets.entitySelection
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2013-2014 Logic Towers
 * @license http://www.yiigems.com/license/
 */
class EntitySelectionDialog extends AppWidget {
    public $dialogId;
    public $title;
    public $width = 720;
    public $height = 400;
    
    public $gridId;
    public $partial;
    public $partialParams;
    public $nameExpression = "$(this).find( 'td').eq(1).text()";
    public $idExpression = "$(this).find( 'td').eq(0).find('input').val()";
    
    public $fieldSelector;
    public $hiddenFieldSelector;
    public $script = "";
    
    
    public function init(){
        parent::init();
        JQueryUI::registerYiiJQueryUICss();
        JQueryUI::registerYiiJQueryUIScript();
        
       echo CHtml::openTag( "div", array('id'=>$this->dialogId, 'style'=>'display:none'));
       echo Yii::app()->controller->renderPartial($this->partial, $this->partialParams, true);
       echo CHtml::closeTag("div");
    }
    
    public function run(){
        $cs = Yii::app()->clientScript;
       $cs->registerScript( UniqId::get("scr-"), "
           $('#$this->dialogId').dialog({
                title: '$this->title',
                autoOpen: false,
                height: $this->height,
                width:$this->width,
                modal:true,
                buttons: {
                    OK:function(){
                        $('$this->fieldSelector').attr( 'value', '' );
                        $('$this->hiddenFieldSelector').attr( 'value', '' );
                        var selectedId = $.fn.yiiGridView.getSelection('$this->gridId');
                        if ( selectedId != null ){
                            $('#$this->gridId table tr').each( function(){
                                if ( $(this).hasClass( 'selected') ){
                                    var text = eval( \"$this->nameExpression\");
                                    $('$this->fieldSelector').attr( 'value', text );
                                        
                                    text = eval( \"$this->idExpression\");
                                    $('$this->hiddenFieldSelector').attr( 'value', text );
                                }
                            });
                        }
                        $this->script
                        $('#$this->dialogId').dialog('close');
                    },
                    Cancel: function(){
                        $('#$this->dialogId').dialog('close');
                    }
                }
            });
       ");
    }
}

?>
