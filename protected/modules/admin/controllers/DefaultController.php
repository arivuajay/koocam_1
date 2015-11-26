<?php

/**
 * Admin controller
 */
class DefaultController extends Controller {

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actions() {
        return array(
            'download' => 'application.components.actions.download',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'error', 'request-password-reset'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile', 'changePassword'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
//                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
        $this->layout = '//layouts/login';

        if (!Yii::app()->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm();

        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()):
                $this->goHome();
            endif;
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->getModule('admin')->user->loginUrl);
    }

    public function actionProfile() {
        $id = Yii::app()->user->id;
        $model = Admin::model()->findByPk($id);

        $this->performAjaxValidation($model);
        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->validate()) {
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Profile updated successfully');
                $this->refresh();
            }
        }
        
        $this->render('profile', compact('model'));
    }

    public function actionChangePassword() {
        $model = new Admin;
        $model = Admin::model()->findByAttributes(array('admin_id' => Yii::app()->user->id));
        $model->scenario = 'changePwd';

        $this->performAjaxValidation($model);
        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            $valid = $model->validate();
            if ($valid) {
                $model->password_hash = Myclass::encrypt($model->new_password);
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Password changed successfully.');
                    $this->refresh();
                } else {
                    Yii::app()->user->setFlash('danger', 'Password can not be changed, Please try again.');
                    $this->refresh();
                }
            }
        }

        $this->render('changePassword', array('model' => $model));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
                Yii::app()->end();
            } else {
                $name = Yii::app()->errorHandler->error['code'] . ' Error';
                $message = Yii::app()->errorHandler->error['message'];
                $this->render('error', compact('error', 'name', 'message'));
            }
        }
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if (isset($_POST['PasswordResetRequestForm'])) {
            $model->attributes = $_POST['PasswordResetRequestForm'];
            if ($model->validate()):
                if ($model->sendEmail()) {
                    Yii::app()->user->setFlash('success', 'Check your email for further instructions.');
                    $this->goHome();
                } else {
                    Yii::app()->user->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            endif;
        }

        $this->render('requestPasswordResetToken', array(
            'model' => $model,
        ));
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (isset($_POST['ResetPasswordForm'])) {
            $model->attributes = $_POST['ResetPasswordForm'];
            if ($model->validate() && $model->resetPassword()):
                Yii::app()->user->setFlash('success', 'New password was saved.');
                $this->goHome();
            endif;
        }

        $this->render('resetPassword', array(
            'model' => $model,
        ));
    }
    
    public function actionScreens($path) {
        if ($path) {
            $this->render('screens', compact('path'));
        }
    }

    public function actionTestmail() {
        $mail = new Sendmail;
        $message = "test";
        $subject = "Tetss";

        try {
            mail("prakash.paramanandam@arkinfotec.com", "My subject", "Test");
        } catch (Exception $exc) {
            echo 'fail';
            echo $exc->getTraceAsString();
        }
        exit;

        var_dump($mail->send('prakash.paramanandam@arkinfotec.com', $subject, $message));
        exit;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
