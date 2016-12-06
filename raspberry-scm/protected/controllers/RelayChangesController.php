<?php

class RelayChangesController extends BaseController {

    /**
     * Class constructor
     *
     */
    public function init() {
        $this->pageTitle = Yii::app()->name . ' - Relay Changes';
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
    public function actionViewActual() {
        Yii::app()->functions->simpleAccessProvision();
        $res = Yii::app()->RelayController->getRelayStatus(NULL, false);
        $relay_setts = Setting::model()->findAll(
                'setting_id LIKE :match', array(':match' => "relay_%")
        );
        $this->render('_viewActualStatus', array(
            'status' => $res,
            'relayInfo' => $relay_setts,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new RelayChanges;
        $categories = array(0 => 'OFF', 1 => 'ON', 2 => 'PULSE');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RelayChanges'])) {
            $model->attributes = $_POST['RelayChanges'];
            $res = Yii::app()->RelayController->changeRelayStatus($model->relay_number, $model->action);
            if ($res && $model->save())
                $this->redirect(array('view', 'id' => $model->date));
            else {
                Yii::log("Error either changing relay status, or saving the changes. Relay Number: $model->relay_number Action: $model->action");
            }
        }

        $this->render('create', array(
            'model' => $model,
            'categories' => $categories,
        ));
    }

    /**
     * Ajax change status of a relay.
     * @return type
     */
    public function actionChangeRelay() {
        $relayId = Yii::app()->request->getParam('id', null);
        $status = Yii::app()->request->getParam('status', null);
        if ($relayId !== null && $status !== null) {
            $res = Yii::app()->RelayController->changeRelayStatus($relayId, $status);
            $model = RelayChanges::model();
            $model->relay_number = intval($relayId);
            $model->action = intval($status);
            $model->log = "From ajax in live view";
            if ($model->save()) {
                $this->renderJSON("Success");
            } else {
                if ($model->save()) {
                    $this->renderJSON("Error");
                }
            }
            Yii::app()->end();
        }
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
        $categories = array(0 => 'OFF', 1 => 'ON', 2 => 'PULSE');
        if (isset($_POST['RelayChanges'])) {
            $model->attributes = $_POST['RelayChanges'];
            $res = Yii::app()->RelayController->changeRelayStatus($model->relay_number, $model->action);
            if ($res && $model->save())
                $this->redirect(array('view', 'id' => $model->date, 'categories' => $categories));
            else {
                Yii::log("Error either changing relay status, or saving the changes. Relay Number: $model->relay_number Action: $model->action");
            }
        }

        $this->render('update', array(
            'model' => $model,
            'actions' => $actions,
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
        Yii::app()->functions->simpleAccessProvision();
        $dataProvider = new CActiveDataProvider('RelayChanges');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        Yii::app()->functions->simpleAccessProvision();
        $model = new RelayChanges('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RelayChanges']))
            $model->attributes = $_GET['RelayChanges'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RelayChanges the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RelayChanges::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RelayChanges $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'relay-changes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
