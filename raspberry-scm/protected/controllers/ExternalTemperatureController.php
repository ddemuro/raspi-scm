<?php

class ExternalTemperatureController extends BaseController {

    /**
     * Class constructor
     *
     */
    public function init() {
        $this->pageTitle = Yii::app()->name . ' - External Temperature';
        /* Run init */
        parent::init();
    }

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        Yii::app()->functions->simpleAccessProvision();
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewAll() {
        Yii::app()->functions->simpleAccessProvision();
        $model = Setting::model()->findAll('setting_id=:sett', array(':sett' => 'external_temp_sensor_pin'));
        $temps = array();
        foreach ($model as $pin) {
            $res = Yii::app()->TemperatureController->getHumidityTemp($pin->setting, $pin->extended);
            if ($res === NULL) {
                Yii::log("Error loading temperature information, skipping...");
                Yii::log("Confirm you've added he root password to the config files....");
                continue;
            }
            $tempModel = new ExternalTemperature();
            $tempModel->temperature = $res[1];
            $tempModel->humidity = $res[0];
            $tempModel->date = date('Y-m-d H:m:s');
            $tempModel->log = "DataPIN = $pin->setting, Extended = $pin->extended";
            array_push($temps, $tempModel);
        }

        $this->render('_view', array(
            'model' => $temps,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new ExternalTemperature;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ExternalTemperature'])) {
            $model->attributes = $_POST['ExternalTemperature'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->date));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        Yii::app()->functions->simpleAccessProvision();
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ExternalTemperature'])) {
            $model->attributes = $_POST['ExternalTemperature'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->date));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        Yii::app()->functions->simpleAccessProvision();
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $startOfDay = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "-7 days"));
        $endOfDay = date('Y-m-d H:i:s');
        $criteria = new CDbCriteria(array('order' => 'date DESC'));
        $criteria->addBetweenCondition('date', $startOfDay, $endOfDay);
        $today = ExternalTemperature::model()->findAll($criteria);
        $times = array();
        $temps = array();
        $humidity = array();
        // Filter data
        foreach ($today as $t) {
            array_push($times, $t->date);
            array_push($temps, $t->temperature);
            array_push($humidity, $t->humidity);
        }
        $dataProvider = new CActiveDataProvider('ExternalTemperature', array(
            'criteria' => array(
                'order' => 'date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10)));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'times' => $times,
            'temps' => $temps,
            'humid' => $humidity,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new ExternalTemperature('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ExternalTemperature']))
            $model->attributes = $_GET['ExternalTemperature'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ExternalTemperature the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ExternalTemperature::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ExternalTemperature $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'external-temperature-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
