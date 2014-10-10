<?php

/**
 * A wrapper widget around Impromptu JQuery plugin.
 * The Impromptu plugin is typically used to display a confirmation from the user
 * but also can be used to display information, warning or error.
 * 
 * Confirming a link navigation:
 * <pre>
 * 
 * <a id="link" href="http://www.google.com">Go to Google</a>     
 * <?php
 * $dlg = $this->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
 * $dlg->confirmLinkNavigation( "#link", "Are you sure you want to go to google?");
 * ?>
 * 
 * </pre>
 * 
 * Confirming an action:
 * <pre>
 * 
 * <a id="link" href="javascript:void(0)">Do Something</a> 
 * <?php
 * $dlg = $this->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
 * $dlg->confirmAction( "#link", "Are you sure you want to do something?", "
 *    alert("Hello world")
 * ");
 * ?>
 * 
 * </pre>
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.impromptu
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.AppWidget");

class Impromptu extends AppWidget {
    /**
     * Sets up asset information for this widget. 
     */
    protected function setupAssetsInfo() {
        JQuery::registerJQuery();
        $this->addAssetInfo(
            "impromptu.css",
            dirname(__FILE__) . "/assets"
        );
        
        $this->addAssetInfo(
            "impromptu.js",
            dirname(__FILE__) . "/assets"
        );
    }
    
    /**
     * Initializes this widget. 
     */
    public function init(){
        parent::init();
        $this->registerAssets();
    }
    
    /**
     * Returns a script that will display an information message upon execution.
     * @param string $message the message to be displayed.
     * @param string $cbMethod the callback method which defaults to null.
     * @return string a script to display information message. 
     */
    public function getInformationPopupScript( $message, $cbMethod=null ){
        $markup = $this->createInformationMarkup($message);
        if ( $cbMethod == null ) $cbMethod = "function(){}";
        $script = "$.prompt( '$markup', {
             top: '30%',
             opacity: 0.40,
             buttons:{ OK:true },
             callback: $cbMethod
        });";
        return $script;
    }
    
    /**
     * Returns a script that will display a warning message upon execution.
     * @param string $message the message to be displayed.
     * @param string $cbMethod the callback method which defaults to null.
     * @return string a script to display warning message. 
     */
    public function getWarningPopupScript( $message, $cbMethod=null ){
        $markup = $this->createWarningMarkup($message);
        if ( $cbMethod == null ) $cbMethod = "function(){}";
        $script = "$.prompt( '$markup', {
             top: '30%',
             opacity: 0.40,
             buttons:{ OK:true },
             callback: $cbMethod
        });";
        return $script;
    }

    /**
     * Returns a script that will display a error message upon execution.
     * @param string $message the message to be displayed.
     * @param string $cbMethod the callback method which defaults to null.
     * @return string a script to display error message. 
     */
    public function getErrorPopupScript( $message, $cbMethod=null ){
        $markup = $this->createErrorMarkup($message);
        if ( $cbMethod == null ) $cbMethod = "function(){}";
        $script = "$.prompt( '$markup', {
             top: '30%',
             opacity: 0.40,
             buttons:{ OK:true },
             callback: $cbMethod
        });";
        return $script;
    }

    /**
     * Returns a script that will display a confirmation message upon execution.
     * @param string $message the message to be displayed.
     * @param string $cbMethod the callback method which defaults to null.
     * @return string a script to display confirmation message. 
     */
    public function getConfirmationPopupScript( $message, $cbMethod=null ){
        $markup = $this->createConfirmationMarkup($message);
        if ( $cbMethod == null ) $cbMethod = "function(){}";
        $script = "$.prompt( '$markup', {
             top: '30%',
             opacity: 0.40,
             buttons:{ OK:true, Cancel:false},
             callback: $cbMethod
        });";
        return $script;
    }
    
    /**
     * @param string $message the message to be displayed.
     * @return string The markup for the information message.
     */
    private function createInformationMarkup($message){
        $publishUrl = $this->getAssetPublishPath("impromptu.css");
        $imageUrl = $publishUrl . "/images/info.gif";
        return $this->createMessageMarkup( $imageUrl, $message);
    }

    /**
     * @param string $message the message to be displayed.
     * @return string The markup for the warning message.
     */
    private function createWarningMarkup($message){
        $publishUrl = $this->getAssetPublishPath("impromptu.css");
        $imageUrl = $publishUrl . "/images/warn.gif";
        return $this->createMessageMarkup( $imageUrl, $message);
    }
    
    /**
     * @param string $message the message to be displayed.
     * @return string The markup for the error message.
     */
    public function createErrorMarkup($message){
        $publishUrl = $this->getAssetPublishPath("impromptu.css");
        $imageUrl = $publishUrl . "/images/error.png";
        return $this->createMessageMarkup( $imageUrl, $message);
    }

    /**
     * @param string $message the message to be displayed.
     * @return string The markup for the confirmation message.
     */
    private function createConfirmationMarkup($message){
        $publishUrl = $this->getAssetPublishPath("impromptu.css");
        $imageUrl = $publishUrl . "/images/confirm.gif";
        return $this->createMessageMarkup( $imageUrl, $message);
    }
    
    /**
     * Creates the markup given an image and a message.
     * @param string $imagePath path of an image.
     * @param string $message the message to be displayed.
     * @return string a markup including the image and the message.
     */
    public function createMessageMarkup($imagePath, $message){
        $imageTag = "<img src='$imagePath' alt='' style='vertical-align:middle;width:32px;height:32px'/>";
        $imageTag = str_replace( "'", "\"", $imageTag );
        $messageTag = '<span style="font-size:1.5em">' . $message. '</span>';
        $markup = '
            <div>
               <table border="0">
                    <tr>
                        <td style="width:32px">' . $imageTag . '</td>
                        <td style="padding-left:10px">&nbsp;</td>
                        <td style="vertical-align:middle">' . $messageTag . '</td>
                    </tr>
               </table>
            </div>
        ';
        $markup = preg_replace('/\s+/', ' ',$markup);
        return $markup;
    }
    
    /**
     * Displays a confirmation message on clicking on the element selected 
     * by the JQUery selector.
     * @param string $selector specifies a JQuery selector.
     * @param string $message the message to be displayed.
     * @param string $script the script to be executed on confirmation.
     */
    public function confirmAction($selector, $message, $script ){
        $script = $this->getConfirmationPopupScript($message, "function(v,m,f){
            if (v==null || v==false) return;
            $script
        }");
        Yii::app()->clientScript->registerScript( $selector, "
            $('body').undelegate('$selector', 'click');
            $('body').delegate( '$selector', 'click', function(){
                var th = $(this);
                $script
                return false;
            });
        ");
    }
    
    /**
     * Displays a confirmation message on clicking on an anchor selected 
     * by the JQUery selector.
     * @param string $selector specifies a JQuery selector.
     * @param string $message the message to be displayed.
     */
    public function confirmLinkNavigation($selector, $message){
        $script = $this->getConfirmationPopupScript($message, "function(v,m,f){
            if (v==null || v==false) return;
            window.location = $('$selector').attr('href');
        }");
        Yii::app()->clientScript->registerCoreScript('yii');
        Yii::app()->clientScript->registerScript( $selector, "
            $('body').undelegate('$selector', 'click');
            $('body').delegate( '$selector', 'click', function(){
                $script
                return false;
            });
        ");
    }
    
    
    /**
     * Submits a form after displaying a confirmation message to the user.
     * @param type $btnSelector JQuery selector for submit button.
     * @param type $formSelector JQuery selector for a form.
     * @param type $message The confirmation message.
     */
    public function confirmFormSubmission($btnSelector, $formSelector, $message){
        $warningScript = $this->getWarningPopupScript( "Form submission Failed" );
        
        $script = $this->getConfirmationPopupScript($message, "function(v,m,f){
            if (v!=true) return;
            
            var form = $('$btnSelector').closest('form');
            if ( '$formSelector' != '' ) form = $('$formSelector');
            if ( form.length > 0 ){
               form.submit();
            }
            else {
               $warningScript
            }
        }");
        Yii::app()->clientScript->registerCoreScript('yii');
        Yii::app()->clientScript->registerScript("$btnSelector", "
            $('body').undelegate('$btnSelector', 'click');
            $('body').delegate( '$btnSelector', 'click', function(){
                var th = this;
                $script
                return false;
            });
        ");
    }
}

?>
