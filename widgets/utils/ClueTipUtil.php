<?php
/**
 * This class is deprecated. Use Tooltip widget instead.
 * An utility class to create ClueTip widget easily.
 * There are several ways you can create a ClueTip widget by using the widget class
 * directly. Same methods are also available though the utility class.
 * 
 * You can put the content of your tooltip in an HTML element on the web page and
 * pass the id of the element to the clueTip method to create the tip.
 * 
 * <pre>
 *
 * This paragraph which contains a tooltip over the word
 * <?php ClueTipUtil::clueTip("YiiGems", "This is tooltip title", "myToolTip")?>
 * and the content of the tooltip is taken from an element with id "myToolTip" on
 * this web page.
 *
 * <div id="myToolTip">
 *   People who think that they know everything are a great annoyance to
 *   those of us who do - Isaac Asimov.
 * </div>
 * 
 * </pre>
 *
 * Alternatively you can put the content to be displayed as tooltip between start and  end calls as follows.
 * Note that in the following paragraph, the word "YiiGems" will display the tooltip.
 *
 * <pre>
 *
 * This paragraph contains a tooltip over the word
 * <?php ClueTipUtil::clueTipStart("YiiGems", "This is tooltip title")?>
 * <div>
 *    People who think that they know everything are a great annoyance to
 *    those of us who do - Isaac Asimov.
 * </div>
 * <?php ClueTipUtil::clueTipEnd()?>
 * and the content of the tooltip is was placed between start and end calls.
 *
 * </pre>
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.utils
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.tooltips.ClueTip");

class ClueTipUtil {
    /**
     * Method to generate a tooltip with content from an HTML element on the web page.
     * @param $label the html content on which the tooltip is displayed.
     * @param $title the title for the tooltip.
     * @param $contentId the HTML tag id which conatins the tooltip content.
     * @param bool $captureOutput whether the output from the widget will be captured or echoed.
     * @return string returns null if $captureOutput is false, otherwise returns the markup for the tooltip.
     */
    public static function clueTip($label, $title, $contentId, $captureOutput=false) {
        $controller = Yii::app()->controller;
        return $controller->widget('ext.yiigems.widgets.tooltips.ClueTip', array(
            'linkContent' => $label,
            'title' => $title,
            'contentId' => $contentId,
            'contentInline' => false,
            'closePosition'=>'bottom'
        ), $captureOutput);
    }

    /**
     * Creates a tooltip with its content from an ajax response.
     * @param $label specifies the label on which the tooltip is displayed. This can be any valid HTML markup including
     * an image tag.
     * @param $title the title to be displayed on the tooltip.
     * @param $ajaxUrl url for ajax request.
     * @param bool $captureOutput whether output from the widget will be captured or echoed.
     * @return string returns null if $captureOutput is false, otherwise returns the markup for the tooltip.
     */
    public static function ajaxClueTip($label, $title, $ajaxUrl, $captureOutput=false) {
        $controller = Yii::app()->controller;
        return $controller->widget('application.widgets.tooltips.ClueTip', array(
            'linkContent' => $label,
            'title' => $title,
            'ajaxUrl' => $ajaxUrl,
            'contentInline' => false,
            'sticky' => true,
            'width'=>400,
            'closePosition'=>'bottom'
        ), $captureOutput);
    }

    /**
     * @param $label the label on top of which the tooltip will be displayed.
     * @param $title the title of the displayed tooltip. Can be nulll in which case to title is displayed.
     */
    public static function start($label, $title) {
        $controller = Yii::app()->controller;
        $controller->beginWidget('ext.yiigems.widgets.tooltips.ClueTip', array(
            'linkContent' => $label,
            'title' => $title,
            'contentInline' => true,
        ));
    }

    /**
     * Marks the end of tooltip content.
     */
    public static function end(){
        Yii::app()->controller->endWidget();
    }
}

?>
