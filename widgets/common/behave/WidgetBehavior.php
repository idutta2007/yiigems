<?php

/**
 * WidgetBehavior class file.
 *
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common.behave
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.utils.GradientUtil");

class WidgetBehavior extends CBehavior {
    protected $assetsInfo = array();
    private $jsPublishPosition = 0;
    
    public function addAssetInfo( $name, $assetDir){
        $assetNames = is_array($name) ? $name : array($name);
        foreach ($assetNames as $assetName) {
            $this->assetsInfo[] = array(
                'name' => $assetName,
                'assetDir' => $assetDir
            );
        }     
    }

    public function addYiiGemsCommonCss(){
        $this->addAssetInfo(
            "cssGemsCommon.css",
            $this->getCommonAssetDir()
        );
    }

    public function addFontAwesomeCss(){
        $this->addAssetInfo(
            "font-awesome.css",
            $this->getCommonAssetDir()
        );
    }

    /**
     * Adds one or more assets for gradients used by this widget.
     * Convenient method for base classes to indicate that an widget uses the
     * named gradient. This class adds the corresponding CSS file to the list
     * of assets used by this widget so that the CSS file is published and
     * registered correctly.
     * @param string $gradient name of a YiiGems gradient.
     */
    protected function addGradientAssets( $gradient ){
        $gradients = is_array($gradient) ? $gradient : array($gradient);
        foreach($gradients as $gradient){
            if ($gradient) {
                $this->addAssetInfo(
                    GradientUtil::getCssFileForGradient($gradient),
                    GradientUtil::getGradientAssetDir($gradient)
                );
            }
        }
    }
    
    public function getAssetPublishPath($name){
         foreach( $this->assetsInfo as $assetInfo ){
             if ( $assetInfo['name'] == $name){
                 return $assetInfo['publishPath'];
             }
         }
         throw CHttpException( "Asset publish path not found" );
    }
     
    public function getCommonAssetDir(){
        return dirname(__FILE__) . "/../../common/assets/common";
    }
    
    public function getGradientAssetDir($gradientName){
        return GradientUtil::getGradientAssetDir($gradientName);
    }
    
    public function registerAssets() {
        $this->publishAssets();
        $this->registerCssFiles();
        $this->registerJsFiles();
    }
    
    public function publishAssets() {
        foreach( $this->assetsInfo as &$info ){
            $assetDir = $info['assetDir'];
            $info['publishPath'] = Yii::app()->getAssetManager()->publish($assetDir);
        }
    }
    
    public function registerCssFiles() {
        foreach( $this->assetsInfo as $info ){
            $cssFile = $info['name'];
            if (substr($cssFile, -strlen(".css")) == ".css"){
                $cssPath = $info['publishPath'] . "/" . $cssFile;
                Yii::app()->getClientScript()->registerCssFile($cssPath);
            }
        }
    }
    
    public function registerJsFiles() {
        foreach( $this->assetsInfo as $info ){
            $jsFile = $info['name'];
            if (substr($jsFile, -strlen(".js")) == ".js"){
                $jsPath = $info['publishPath'] . "/" . $jsFile;
                Yii::app()->getClientScript()->registerScriptFile($jsPath, $this->jsPublishPosition);
            }
        }
    }
}

?>
