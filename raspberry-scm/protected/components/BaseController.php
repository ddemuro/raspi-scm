<?php

/**
 * Base controller for all controllers under this application
 */
class BaseController extends CController {

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    
    /**
     * This is the general page title, We use this instead of the
     * applications pageTitle since it's not designed to be a string
     * But rather an array so we could reverse it later for SEO improvements
     *
     * @var string
     * */
    public $pageTitle = array();

    /**
     * @var array - array of {@link CBreadCrumbs} link
     */
    public $breadcrumbs = array();
    
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    // Available menu if options exist
    public $extraMenu = array();
    
    /**
     * Class constructor
     *
     */
    public function init() {
        $this->menuExtras();
        /* Run init */
        parent::init();
    }
    
    /**
     * If options exist, we load them.
     */
    public function menuExtras(){
        $this->extraMenu = array(
                array('label' => 'Home', 'url' => array('/site/index')),
                array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                array('label' => 'Contact', 'url' => array('/site/contact')),
                array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => 'Users', 'url' => array('/User'), 'visible' => !Yii::app()->user->isGuest),
        );
        if (Yii::app()->functions->yiiparam('ups_status') !== null) {
            array_push($this->extraMenu, array('label' => 'UPS', 'url' => array('/ups'), 'visible' => !Yii::app()->user->isGuest));
        }
        if (Yii::app()->functions->yiiparam('external_sensor_program') !== null) {
            array_push($this->extraMenu, array('label' => 'External Temperature', 'url' => array('/ExternalTemperature'), 'visible' => !Yii::app()->user->isGuest));
        }
        if (Yii::app()->functions->yiiparam('cpu_tmp') !== null) {
            array_push($this->extraMenu, array('label' => 'Internal Temperature', 'url' => array('/InternalTemperature'), 'visible' => !Yii::app()->user->isGuest));
        }
        if (Yii::app()->functions->yiiparam('crelay') !== null) {
            array_push($this->extraMenu, array('label' => 'Relay Controller', 'url' => array('/RelayChanges'), 'visible' => !Yii::app()->user->isGuest));
        }
        if (Yii::app()->functions->yiiparam('infrared_prog') !== null) {
            array_push($this->extraMenu, array('label' => 'Infrared Controller', 'url' => array('/InfraredEvents'), 'visible' => !Yii::app()->user->isGuest));
        }
        array_push($this->extraMenu, array('label' => 'Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest));
    }
}
