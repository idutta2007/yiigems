<?php
/**
 * The base class for widgets in YiiGems extension. 
 * AppWidget provides methods to register mutiple assets from different folders 
 * and also provides some other methods to include appropriate stylesheets for 
 * gradients defined by YiiGems extension.
 * 
 * @author Indra K Dutta <idutta2007@gmail.com>
 * @version 1.0
 * @package ext.yiigems.widgets.common
 * @link http://www.yiigems.com/
 * @copyright Copyright &copy; 2010-2013 Indra Dutta
 * @license http://www.yiigems.com/license/
 */

Yii::import("ext.yiigems.widgets.common.utils.GradientUtil");

class AppWidget extends CWidget {
    /**
     * @var string HTML id of the widget.
     */
    public $id = null;
    
    /**
     * @var string HTML id of the widget.
     */
    public $addClass = "";
    
    /**
     * The scenario associated with the widget. 
     * A scenario is the use case of an widget which will determines default
     * values for the widget properties when it is created. An empty string
     * denotes the default scenario.
     * @var string
     */
    public $scenario = null;
    
    /**
     * The skin class name associated with this widget. 
     * The skin class holds the values of widget properties for different 
     * scenarios.
     * @var string
     */
    protected $skinClass = null;
    
    /**
     * The list of assets required by this widget. 
     * An asset can be a CSS file or a javacript file.
     * @var array
     */
    protected $assetsInfo = array();
    
    /**
     * The publish location for the javascript files associated with this widget.
     * Defaults to zero means the script files will be added to the end of the header.
     * @var integer
     */
    protected $jsPublishPosition = 0;
    
    /**
     * Return the value of the class attribte for the conatiner class. The class
     * passed to this method is combined with addClass attribute to create the
     * class attribute.
     * @param string $mainClass specifies a css class
     * @return string returns the effective class attribute.
     */
    protected function getClassAttributeValue( $mainClass ){
        if ( $this->addClass ) return "$mainClass $this->addClass";
        return $mainClass;
    }

    /**
     * Method to provide information about the assets used by this widget. 
     * Every derived class that uses an asset should override this method to 
     * add appropriate assets by calling addAssetInfo method.
     */
    protected function setupAssetsInfo(){
    }
    
    /**
     * Method to set the widget properties to default values. 
     * If a derived class overrides this method, the parent method
     * should be called; otherwise default values according to current skin and
     * scenario will not be set correctly.
     * @return type none
     */
    protected function setMemberDefaults(){
        // The skin class for an widget may not exist
        $skinClass = $this->skinClass;
        if (!$skinClass){
            return;
            //throw new CHttpException("Skin class not set" );
        };
        
        // Update copied fields
        $fields = $this->getCopiedFields();
        foreach( $fields as $field ){
            if ( !isset($this->$field)) {
                // First copy from default scenario
                $this->$field = $skinClass::${$field};
                
                // Copy from scenario specified in the widget
                if ($this->scenario && array_key_exists( $this->scenario, $skinClass::$scenarios)){
                    if (array_key_exists($field, $skinClass::$scenarios[$this->scenario])){
                        $this->$field = $skinClass::$scenarios[$this->scenario][$field];
                    }
                }
            }
        }
        
        // Update merged fields
        // **** Note ****
        // If a scenario is set, user options is merged with options from the scenario
        // Otherwise user options are merged with default scenarios
        $fields = $this->getMergedFields();
        foreach( $fields as $field ){
            if ( $this->$field == null ) $this->$field = array();
            if (is_array($this->$field) ) {
                
                // Then merge from scenario specified in the widget
                if ($this->scenario && array_key_exists( $this->scenario, $skinClass::$scenarios)){
                    if (array_key_exists($field, $skinClass::$scenarios[$this->scenario])){
                        $this->$field = array_merge($skinClass::$scenarios[$this->scenario][$field], $this->$field);
                    }
                }
                
                // merge with default scenario
                else if ( is_array($skinClass::${$field})){
                    $this->$field = array_merge($skinClass::${$field}, $this->$field);
                }
            }
            else {
                Yii::log("Field $field is not an array", CLogger::LEVEL_TRACE, "AppWidget");
            }
        }
    }
    
    /**
     * Method to indicate which properties should be copied from skin class.
     * A widget derived from AppWidget has control over the properties which should
     * be copied from the skin class when the widget is created. In a derived class
     * this method should return the names of the properties which are copied
     * from the skin class. 
     * @return array of widget prioprty names which are copied from skin class.
     */
    protected function getCopiedFields(){
        return array();
    }
    
    /**
     * Method to indicate which properties should be merged from skin class.
     * A widget derived from AppWidget can merge an array property from the 
     * skin class into its own array. This is useful when user overrides some value
     * of the array while creating the widget.
     * @return array of widget prioprty names which are copied from skin class.
     */
    protected function getMergedFields(){
        return array();
    }
    
    /**
     * Adds a asset to the list of assets used by thi widget.
     * An asset may be a CSS file or a javascript file.
     * @param type $name name of the CSS or javascript file used by this widget.
     * @param string $assetDir is path of the absolute asset directory
     */
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
        $this->addAssetInfo( "cssGemsCommon.css", $this->getCommonAssetDir() );
    }

    public function addFontAwesomeCss(){
        $this->addAssetInfo( "font-awesome.css", $this->getCommonAssetDir() );
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
                if ($gradient != "none") {
                    $this->addAssetInfo(
                         GradientUtil::getCssFileForGradient($gradient), GradientUtil::getGradientAssetDir($gradient)
                    );
                }
            }
        }
    }

    /**
     * Returns the name of the asset publish path given the name of the asset.
     * @param string $name name of the asset.
     * @return string  the path of the directory to which asset the published.
     * @throws CHttpException if asset publish path is not found.
     */
    public function getAssetPublishPath($name){
         foreach( $this->assetsInfo as $assetInfo ){
             if ( $assetInfo['name'] == $name){
                 return $assetInfo['publishPath'];
             }
         }
         throw new CHttpException( "Asset publish path not found" );
    }
    
    /**
     * Initializes this widget by setting default values and setting up assets.
     * The default values are based on current skin and scenario. The 
     * assets used by the widget are not published by this method. You have to 
     * specifically call registerAssets in derived classes to publish the assets. 
     * Also derived classes init method must call this method preferably at the 
     * start of the derived method.
     */
    public function init(){
        $this->setMemberDefaults();
        $this->setupAssetsInfo();
    }
    
    /**
     * Returns the common asset directory for YiiGems. 
     * The common assets directory contains the definitions of gradients,
     * shadows and borders used by the extension.
     * @return string 
     */
    protected function getCommonAssetDir(){
        return dirname(__FILE__) . "/../common/assets/common";
    }
    
    /**
     * Registers all assets used by this widget.
     * This method first publishes all assets used by this widget and then registers
     * any CSS or javascript files on the web page.
     */
    protected function registerAssets() {
        $this->publishAssets();
        $this->registerCssFiles();
        $this->registerJsFiles();
    }
    
    /**
     * Publishes all assets used by this widget. 
     * Prior to calling this method setupAssetInfo must be called from somewhere 
     * to build the list of assets to be published. 
     */
    private function publishAssets() {
        foreach( $this->assetsInfo as &$info ){
            $assetDir = $info['assetDir'];
            $info['publishPath'] = Yii::app()->getAssetManager()->publish($assetDir);
        }
    }
    
    /**
     * Registers the CSS files used by this widget 
     */
    private function registerCssFiles() {
        foreach( $this->assetsInfo as $info ){
            $cssFile = $info['name'];
            if (substr($cssFile, -strlen(".css")) == ".css"){
                $cssPath = $info['publishPath'] . "/" . $cssFile;
                Yii::app()->getClientScript()->registerCssFile($cssPath);
            }
        }
    }
    
    /**
     * Registers the javascript files used by this widget 
     */
    protected function registerJsFiles() {
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
