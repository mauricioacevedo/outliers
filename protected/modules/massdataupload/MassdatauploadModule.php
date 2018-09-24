<?php
/**
 * DashModule class file.
 *
 * @author Joan Harriman Navarro M
 * @license Lesser GPL License
 * @version 1.0
 */

/**
 * Installation:
 *
 * Configuration:
 *
 * <pre>
 * return array(
 *    ...
 *    'modules' => array(
 *       ...
 *      'massdataupload',
 *    ),
 * );
 * </pre>
 *
 * Usage:
 *    To view simple visit 'massdataupload' 
 */

class MassdatauploadModule extends CWebModule
{
  /**
   * @property string Default module controller
   */
  public $defaultController = 'MassDataUpload';

  /**
   * @property string Path to assets folder
   */
  public $assetsFolder = '';

  public function init()
  {
    $this->setImport(array(
      'massdataupload.models.*',
      'massdataupload.components.events.*',
    ));    
     $this->configure(array(
            'preload'=>array('bootstrap'),
             'components'=>array(
                'bootstrap'=>array(
                    'class'=>'application.extensions.yiibooster.components.Bootstrap'
                )
            ),
    ));  
     
    $this->setComponent('massdataevents', new eventManager());
    
    $this->preloadComponents();
    
    if(!defined('MASSUPLOADPATH')){
      define('UPLOADFILEPATH', '/archivos/tmp/massdataupload/');  
    }
    if(!defined('TABLE_PREFIX')){
      define('TABLE_PREFIX','tbl_');  
    }    
    $this->assetsFolder = Yii::app()->assetManager->publish(
      Yii::getPathOfAlias('application.modules.massdataupload.assets')
    );
   # Yii::app()->clientScript->registerCssFile($this->assetsFolder .'/css/style.css');
	
    parent::init();
  }
}
