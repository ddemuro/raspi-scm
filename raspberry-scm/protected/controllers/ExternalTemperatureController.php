<?php

class ExternalTemperatureController extends Controller {

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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewAll() {
        $model = Setting::model()->findAll('setting_id=:sett', array(':sett' => 'external_temp_sensor_pin'));
        $temps = array();
        foreach ($model as $pin) {
            $res = Yii::app()->TemperatureController->getHumidityTemp($pin->setting, $pin->extended);
            Yii::log("Setting information: $pin->setting, Temperature Information: " + var_dump($res));
            if ($res == NULL || count($res) <= 1) {
                Yii::log("Error loading temperature information, skipping...");
                continue;
            }
            $tempModel = new ExternalTemperature();
            $tempModel->temperature = $res[1];
            $tempModel->humidity = $res[0];
            $tempModel->date = date("Y-m-d H:i:s", time());
            $tempModel->log = "DataPIN = $pin->setting, Extended = $pin->extended";
            array_push($temps, $tempModel);
        }

        $this->render('_view', array(
            'model' => $temps,
            'multi' => true,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ExternalTemperature');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
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
