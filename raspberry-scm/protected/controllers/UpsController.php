<?php

class UpsController extends BaseController {

    /**
     * Class constructor
     *
     */
    public function init() {
        $this->pageTitle = Yii::app()->name . ' - UPS';
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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewAll() {
        Yii::app()->functions->simpleAccessProvision();
        $s = Setting::model()->findByAttributes(array('setting_id' => 'ups'));
        $ups = Yii::app()->UpsManager->getAll($s->setting, $s->extended);
        $u = new Ups();
        $u->date = date('Y-m-d H:m:s');
        $u->setting = "$s->setting-$s->extended";
        $u->ups_details = $ups;
        $this->render('view', array(
            'model' => $u,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new Ups;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Ups'])) {
            $model->attributes = $_POST['Ups'];
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

        if (isset($_POST['Ups'])) {
            $model->attributes = $_POST['Ups'];
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
        $startOfDay = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "-365 days"));
        $endOfDay = date('Y-m-d H:i:s');
        Yii::app()->functions->simpleAccessProvision();
        $dataProvider = new CActiveDataProvider('Ups');
        $criteria = new CDbCriteria(array('order' => 'date DESC'));
        $criteria->addBetweenCondition('date', $startOfDay, $endOfDay);
        $today = Ups::model()->findAll($criteria);
        $times = array();
        $input_voltage = array();
        $load = array();
        $batt_voltage = array();
        $batt_charge = array();
        $temperature = array();
        // Check all data and re-format
        foreach ($today as $u) {
            if (strcmp($u->ups_details, "") == 0)
                continue;
            $data_filtered = Yii::app()->UpsManager->obtainDataFromUPS($u->ups_details, 'battery.charge,ups.temperature,input.voltage,battery.voltage,ups.load');
            // Filter data
            foreach ($data_filtered as $df) {
                if (strcmp($df[0], 'battery.charge') == 0)
                    array_push($batt_charge, (int) preg_replace('/\s+/', '', $df[1]));
                if (strcmp($df[0], 'ups.temperature') == 0)
                    array_push($temperature, (int) preg_replace('/\s+/', '', $df[1]));
                if (strcmp($df[0], 'input.voltage') == 0)
                    array_push($input_voltage, (int) preg_replace('/\s+/', '', $df[1]));
                if (strcmp($df[0], 'battery.voltage') == 0)
                    array_push($batt_voltage, (int) preg_replace('/\s+/', '', $df[1]));
                if (strcmp($df[0], 'ups.load') == 0)
                    array_push($load, (int) preg_replace('/\s+/', '', $df[1]));
            }
            $get_time = explode(' ', $u->date);
            array_push($times, $get_time[1]);
        }

        $dataProvider = new CActiveDataProvider('Ups', array(
            'criteria' => array(
                'order' => 'date DESC',
            ),
            'pagination' => array(
                'pageSize' => 3)));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'times' => $times,
            'input_voltage' => $input_voltage,
            'load' => $load,
            'batt_voltage' => $batt_voltage,
            'batt_charge' => $batt_charge,
            'temp' => $temperature,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new Ups('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Ups']))
            $model->attributes = $_GET['Ups'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Ups the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Ups::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Ups $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ups-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
