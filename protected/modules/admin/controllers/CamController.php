<?php

class CamController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'toggle'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'toggle' => array(
                'class' => 'booster.actions.TbToggleAction',
                'modelName' => 'Cam',
            )
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Cam('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Cam'])) {
            $model->attributes = $_GET['Cam'];
        }

        $this->render('index', compact('model'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $booking_model = new CamBooking('search');
        $booking_model->unsetAttributes();
        $booking_model->cam_id = $id;

        $this->render('view', compact('model', 'booking_model'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Cam('admin_create');
        $this->performAjaxValidation($model);

        if (isset($_POST['Cam'])) {
            $model->attributes = $_POST['Cam'];
            $model->setAttribute('cam_media', isset($_FILES['Cam']['name']['cam_media']) ? $_FILES['Cam']['name']['cam_media'] : '');
            if ($model->validate()) {
                if ($model->is_video == 'N') {
                    $model->setUploadDirectory(UPLOAD_DIR . '/users/' . $model->tutor_id);
                    $model->uploadFile();
                }
                if ($model->save(false)) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = new CamExtra;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'cam_id' => $model->cam_id,
                        );
                        $extra_model->setAttribute('extra_file', isset($_FILES['Cam']['name']['extra_file']) ? $_FILES['Cam']['name']['extra_file'] : '');
                        if ($extra_model->validate()) {
                            $extra_model->save(false);
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Cam Created Successfully!!!');
                    $this->redirect(array('/admin/cam/index'));
                }
            }
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
        $model->scenario = 'admin_update';

        if (empty($model->camExtras)) {
            $extra_model = new CamExtra;
        } else {
            $extra_model = $model->camExtras;
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['Cam'])) {
            $model->attributes = $_POST['Cam'];
            $model->setAttribute('cam_media', isset($_FILES['Cam']['name']['cam_media']) ? $_FILES['Cam']['name']['cam_media'] : '');
            if ($model->validate()) {
                if ($model->cam_media) {
                    if ($model->is_video == 'N') {
                        $model->setUploadDirectory(UPLOAD_DIR . '/users/' . $model->tutor_id);
                        $model->uploadFile();
                    }
                } else {
                    unset($model->cam_media);
                }

                if ($model->save(false)) {
                    if ($model->is_extra == 'Y') {
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'cam_id' => $model->cam_id,
                        );
                        if (isset($_FILES['Cam']['name']['extra_file']) && !empty($_FILES['Cam']['name']['extra_file'])) {
                            $extra_model->setAttribute('extra_file', $_FILES['Cam']['name']['extra_file']);
                        }
                        if ($extra_model->validate()) {
                            $extra_model->save(false);
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Cam Updated Successfully!!!');
                    $this->redirect(array('/admin/cam/index'));
                }
            }
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
        $cam = $this->loadModel($id);
        
        if(!empty($cam->camBookings)){
            echo '1';
            exit;
        }
        $cam->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Cam Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/cam/index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Cam the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Cam::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Cam $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cam-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
