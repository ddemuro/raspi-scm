<?php

class InfraredEventsController extends BaseController {

    /**
     * Class constructor
     *
     */
    public function init() {
        $this->pageTitle = Yii::app()->name . ' - Infrared Events';
        /* Run init */
        parent::init();
    }

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
     * Send the IR commands to the LED
     * @param type $util = Util learned by LIRC
     * @param type $command BUTTON to press
     * @return type
     */
    public function ir_cmd($util, $command) {
        Yii::app()->functions->simpleAccessProvision();
        $temoprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        if ($temoprog == NULL) {
            Yii::log('No infrared found...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $util $command", false);
        return $res;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new InfraredEvents;

        $categories = array(
            // Turn ON and OFF AC.
            0 => 'KEY_POWER',
            // Change temp up on AC
            1 => 'KEY_VOLUMEUP',
            // Change temp on AC down
            2 => 'KEY_VOLUMEDOWN',
            // 
            3 => 'KEY_T',
            // Change Mode
            4 => 'KEY_FN',
            5 => 'KEY_BRIGHTNESSUP',
            6 => 'KEY_BRIGHTNESSDOWN',
            7 => 'KEY_BRIGHTNESS_ZERO',
            8 => 'KEY_SLEEP',
            9 => 'KEY_TIME',
        );

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['InfraredEvents'])) {
            $model->attributes = $_POST['InfraredEvents'];
            $this->ir_cmd($model->device, $categories[$model->event]);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->date));
        }

        $this->render('create', array(
            'model' => $model,
            'categories' => $categories,
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

        $categories = array(
            // Turn ON and OFF AC.
            0 => 'KEY_POWER',
            // Change temp up on AC
            1 => 'KEY_VOLUMEUP',
            // Change temp on AC down
            2 => 'KEY_VOLUMEDOWN',
            // 
            3 => 'KEY_T',
            // Change Mode
            4 => 'KEY_FN',
            5 => 'KEY_BRIGHTNESSUP',
            6 => 'KEY_BRIGHTNESSDOWN',
            7 => 'KEY_BRIGHTNESS_ZERO',
            8 => 'KEY_SLEEP',
            9 => 'KEY_TIME',
        );

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['InfraredEvents'])) {
            $model->attributes = $_POST['InfraredEvents'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->date));
        }

        $this->render('update', array(
            'model' => $model,
            'categories' => $categories,
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
        $dataProvider = new CActiveDataProvider('InfraredEvents');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new InfraredEvents('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InfraredEvents']))
            $model->attributes = $_GET['InfraredEvents'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InfraredEvents the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = InfraredEvents::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InfraredEvents $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'infrared-events-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
