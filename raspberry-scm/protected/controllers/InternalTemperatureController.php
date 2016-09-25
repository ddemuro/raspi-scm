<?php

class InternalTemperatureController extends Controller {

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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new InternalTemperature;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['InternalTemperature'])) {
            $model->attributes = $_POST['InternalTemperature'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->date));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewStaticCPU() {
        $res = Yii::app()->TemperatureController->getInternalCPUTemp();
        if ($res == NULL) {
            Yii::log("Error loading temperature information, skipping...");
            return NULL;
        }
        $tempModel = new ExternalTemperature();
        $tempModel->temperature = $res;
        $tempModel->date = date("Y-m-d H:i:s", time());
        $this->render('_view', array(
            'model' => $tempModel,));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewStaticGPU() {
        $res = Yii::app()->TemperatureController->getInternalGPUTemp();
        if ($res == NULL) {
            Yii::log("Error loading temperature information, skipping...");
            return NULL;
        }
        $tempModel = new ExternalTemperature();
        $tempModel->temperature = $res;
        $tempModel->date = date("Y-m-d H:i:s", time());
        $this->render('_view', array(
            'model' => $tempModel,));
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

        if (isset($_POST['InternalTemperature'])) {
            $model->attributes = $_POST['InternalTemperature'];
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
        $dataProvider = new CActiveDataProvider('InternalTemperature');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new InternalTemperature('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InternalTemperature']))
            $model->attributes = $_GET['InternalTemperature'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InternalTemperature the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = InternalTemperature::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InternalTemperature $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'internal-temperature-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
