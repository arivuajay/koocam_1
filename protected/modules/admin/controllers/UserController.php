<?php

class UserController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        $this->render('index', compact('model'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        
        $notifn_model = new Notification;
        
        $cam_model = new Cam('search');
        $cam_model->unsetAttributes();
        $cam_model->tutor_id = $id;
        
        $purchase_model = new Purchase('search');
        $purchase_model->unsetAttributes();
        $purchase_model->user_id = $id;
        
        $job_model = new CamBooking('search');
        $job_model->unsetAttributes();
        $job_model->cam_booking_tutor_id = $id;

        $payments_model = new Transaction('search');
        $payments_model->unsetAttributes();
        $payments_model->user_id = $id;
        $payments_model->userPayments = true;
        
        $this->performAjaxValidation($notifn_model);
        
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Notification')) {
             $notifn_model->attributes = Yii::app()->request->getPost('Notification');
             if($notifn_model->save(false)){
                $mail = new Sendmail;
                $trans_array = array(
                    "{SITENAME}" => SITENAME,
                    "{USERNAME}" => $notifn_model->notifnUser->fullname,
                    "{NOTIFICATION}" => $notifn_model->notifn_message,
                );
                $message = $mail->getMessage('user_notification', $trans_array);
                $Subject = $mail->translate(SITENAME.": New Notification");
                $mail->send($notifn_model->notifnUser->email, $Subject, $message);
                
                Yii::app()->user->setFlash('success', 'Notification Sent to User Successfully!!!');
                $this->redirect(array('/admin/user/view', 'id' => $id));
             }
        }
        
        $this->render('view', compact('model','notifn_model','cam_model', 'purchase_model', 'job_model', 'payments_model'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new User('admin_add');
        $userProfile = new UserProfile;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $userProfile));

        if (isset($_POST['User'], $_POST['UserProfile'])) {
            $model->attributes = $_POST['User'];
            $userProfile->attributes = $_POST['UserProfile'];

            // validate BOTH $a and $b
            $valid = $model->validate();
            $valid = $userProfile->validate() && $valid;

            if ($valid) {
                // use false parameter to disable validation
                $model->save(false);

                $userProfile->user_id = $model->user_id;
                $userProfile->save(false);

                Yii::app()->user->setFlash('success', 'User Created Successfully!!!');
                $this->redirect(array('/admin/user/index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'userProfile' => $userProfile,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'admin_edit';
        $model->password_hash = '';


        $userProfile = UserProfile::model()->findByAttributes(array('user_id' => $model->user_id));

        if ($userProfile == '') {
            $userProfile = new UserProfile;
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $userProfile));

        if (isset($_POST['User'], $_POST['UserProfile'])) {
            $model->attributes = $_POST['User'];
            $userProfile->attributes = $_POST['UserProfile'];

            // validate BOTH $a and $b
            $valid = $model->validate();
            $valid = $userProfile->validate() && $valid;

            if ($valid) {
                if ($model->password_hash) {
                    $model->password_hash = Myclass::encrypt($model->password_hash);
                } else {
                    unset($model->password_hash);
                }

                // use false parameter to disable validation
                $model->save(false);

                $userProfile->user_id = $model->user_id;
                $userProfile->save(false);

                Yii::app()->user->setFlash('success', 'User Created Successfully!!!');
                $this->redirect(array('/admin/user/index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'userProfile' => $userProfile,
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
            Yii::app()->user->setFlash('success', 'User Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/user/index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
