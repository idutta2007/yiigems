<?php

/**
 * An utility class to use Impromptu widget which is a wrapper around the JQuery plugin with the same name.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

class ImpromptuUtil {
    /**
     * Confirms navigation from a link. On clicking on the element specified by the $selector argument which should be
     * an anchor element, the browser navigates to the location specified in the anchor provided used confirms it.
     * @param $selector Specifies a JQuery selector.
     * @param $message the message to be displayed to the user.
     */
    public static function confirmLinkNavigation( $selector, $message ){
        $con = Yii::app()->controller;
        $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
        $dlg->confirmLinkNavigation( $selector, $message );
    }

    /**
     * Executes a script after confirmation.
     * @param $selector  specifies a JQuery selector.
     * @param $message the confirmation message to be displayed to the user.
     * @param $script the script to be executed after confirmation.
     */
    public static function confirmAction( $selector, $message, $script ){
        $con = Yii::app()->controller;
        $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
        $dlg->confirmAction( $selector, $message, $script);
    }

    /**
     * Confirms submission of a form. After clicking on the element specified by the $selector argument, the form
     * identified by the $formSelector argument is submitted.
     * @param $selector the selector for an element clicking on which the confirm message is displayed.
     * @param $formSelector the JQuery selector for a form element.
     * @param $message the message to be displyed to the user.
     */
    public static function confirmFormSubmission( $selector, $formSelector, $message ){
        $con = Yii::app()->controller;
        $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
        $dlg->confirmFormSubmission( $selector, $formSelector, $message );
    }

    /**
     * Displays an information message to the user.
     * @param $message the message to be displayed.
     */
    public static function displayInformation($message){
        $con = Yii::app()->controller;
        $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
        $script = $dlg->getInformationPopupScript( $message );
        Yii::app()->clientScript->registerScript( UniqId::get("scr-"), $script );
    }

    /**
     * Displays a warning message to the user.
     * @param $message the message to be displayed.
     */
    public static function displayWarning($message){
        $con = Yii::app()->controller;
        $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
        $script = $dlg->getWarningPopupScript( $message );
        Yii::app()->clientScript->registerScript( UniqId::get("scr-"), $script );
    }

    /**
     * Displays an error message to the user.
     * @param $message the message to be displayed.
     */
    public static function displayError($message){
        $con = Yii::app()->controller;
        $dlg = $con->widget("ext.yiigems.widgets.impromptu.Impromptu", array());
        $script = $dlg->getErrorPopupScript( $message );
        Yii::app()->clientScript->registerScript( UniqId::get("scr-"), $script );
    }
}

?>
