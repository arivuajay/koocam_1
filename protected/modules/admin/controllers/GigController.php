<?php

class GigController extends Controller {
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
                'modelName' => 'Gig',
            )
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Gig('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Gig'])) {
            $model->attributes = $_GET['Gig'];
        }

        $this->render('index', compact('model'));
    }

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
        $model = new Gig('admin_create');
        $this->performAjaxValidation($model);

        if (isset($_POST['Gig'])) {
            $model->attributes = $_POST['Gig'];
            $model->setAttribute('gig_media', isset($_FILES['Gig']['name']['gig_media']) ? $_FILES['Gig']['name']['gig_media'] : '');
            if ($model->validate()) {
                $model->setUploadDirectory(UPLOAD_DIR . '/users/' . $model->tutor_id);
                $model->uploadFile();
                if ($model->save(false)) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = new GigExtra;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'gig_id' => $model->gig_id,
                        );
                        $extra_model->setAttribute('extra_file', isset($_FILES['Gig']['name']['extra_file']) ? $_FILES['Gig']['name']['extra_file'] : '');
                        if ($extra_model->validate()) {
                            /* temp solution */
                            if (!empty($_FILES['Gig']['name']['extra_file'])) {
                                $user_path = $upl_dir = UPLOAD_DIR . '/users/' . $model->tutor_id;
                                $user_extra_path = $user_path . '/gigextra/';
                                $extra_model->setUploadDirectory($user_extra_path);
                                $newName = trim(md5(time())) . '.' . CFileHelper::getExtension($_FILES['Gig']['name']['extra_file']);
                                $dir = DIRECTORY_SEPARATOR . strtolower(get_class($extra_model)) . DIRECTORY_SEPARATOR;
                                if (move_uploaded_file($_FILES['Gig']['tmp_name']['extra_file'], $user_extra_path . $newName))
                                    $extra_model->extra_file = $dir . $newName;
                            }
                            /* end */
                            $extra_model->save(false);
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Gig Created Successfully!!!');
                    $this->redirect(array('/admin/gig/index'));
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

        if (empty($model->gigExtras)) {
            $extra_model = new GigExtra;
        } else {
            $extra_model = $model->gigExtras;
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['Gig'])) {
            $model->attributes = $_POST['Gig'];
            $model->setAttribute('gig_media', isset($_FILES['Gig']['name']['gig_media']) ? $_FILES['Gig']['name']['gig_media'] : '');
            if ($model->validate()) {
                if ($model->gig_media) {
                    $model->setUploadDirectory(UPLOAD_DIR . '/users/' . $model->tutor_id);
                    $model->uploadFile();
                } else {
                    unset($model->gig_media);
                }

                if ($model->save(false)) {
                    if ($model->is_extra == 'Y') {
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'gig_id' => $model->gig_id,
                        );
                        $extra_model->setAttribute('extra_file', isset($_FILES['Gig']['name']['extra_file']) ? $_FILES['Gig']['name']['extra_file'] : '');
                        if ($extra_model->validate()) {
                            /* temp solution */
                            if (!empty($_FILES['Gig']['name']['extra_file'])) {
                                $user_path = $upl_dir = UPLOAD_DIR . '/users/' . $model->tutor_id;
                                $user_extra_path = $user_path . '/gigextra/';
                                $extra_model->setUploadDirectory($user_extra_path);
                                $newName = trim(md5(time())) . '.' . CFileHelper::getExtension($_FILES['Gig']['name']['extra_file']);
                                $dir = DIRECTORY_SEPARATOR . strtolower(get_class($extra_model)) . DIRECTORY_SEPARATOR;
                                if (move_uploaded_file($_FILES['Gig']['tmp_name']['extra_file'], $user_extra_path . $newName))
                                    $extra_model->extra_file = $dir . $newName;
                            } else {
                                unset($extra_model->extra_file);
                            }
                            /* end */
                            $extra_model->save(false);
                        }
                    } else {
                        if (!empty($model->gigExtras)) {
                            $extra_model->delete();
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Gig Updated Successfully!!!');
                    $this->redirect(array('/admin/gig/index'));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Gig Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/gig/index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Gig the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Gig::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Gig $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gig-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
