<?php

/**
 * Site controller
 */
class UserController extends Controller {

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
                'actions' => array('profile'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('profileupdate', 'sendmessage', 'switchstatus', 'accountsetting', 'editpersonalinformaiton', 'editemailaddress', 'changepassword', 'editsecurityquestionanswer', 'paypaldelete', 'accountdeactivate', 'accountdelete', 'editpaypal', 'editbillinginformaiton'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    public function actionProfile($slug) {
        $model = $this->loadModelSlug($slug);
        $user_profile = $model->userProf;
        if (empty($user_profile)) {
            $user_profile = new UserProfile;
        }

        $message = new Message;
        $this->render('profile', compact('model', 'user_profile', 'message'));
    }

    public function actionProfileupdate() {
        $model = $this->loadModel(Yii::app()->user->id);
        $user_profile = $model->userProf;
        if (empty($user_profile)) {
            $user_profile = new UserProfile;
        }
        $this->performAjaxValidation($user_profile);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('UserProfile')) {
            $user_profile->attributes = Yii::app()->request->getPost('UserProfile');
            $user_profile->user_id = Yii::app()->user->id;
            $user_profile->setAttribute('prof_picture', isset($_FILES['UserProfile']['name']['prof_picture']) ? $_FILES['UserProfile']['name']['prof_picture'] : '');

            if ($user_profile->validate()) {
                $user_profile->setUploadDirectory(UPLOAD_DIR . '/users/' . Yii::app()->user->id);
                $user_profile->uploadFile();

                if ($user_profile->save()) {
                    Yii::app()->user->setFlash('success', "Profile updated successfully!!!");
                    $this->redirect(array('/site/user/profile', 'slug' => $model->slug));
                }
            }
        } else {
            $this->redirect(array('/site/user/profile', 'slug' => $model->slug));
        }
    }

    public function actionSendmessage() {
        $message = new Message;
        $this->performAjaxValidation($message);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Message')) {
            $message->attributes = Yii::app()->request->getPost('Message');
            $model = $this->loadModelSlug($message->userSlug);

            Message::insertMessage($message->message, Yii::app()->user->id, $model->user_id);

            Yii::app()->user->setFlash('success', "Message sent successfully!!!");
            $this->redirect(array('/site/user/profile', 'slug' => $model->slug));
        }
    }

    public function actionAccountsetting() {
        $this->layout = '//layouts/user_dashboard';
        $model = $this->loadModel(Yii::app()->user->id);
        $this->render('account_setting', compact('model'));
    }

    public function actionEditpersonalinformaiton() {
        $model = $this->loadModel(Yii::app()->user->id);
        $user_profile = $model->userProf;
        if (empty($user_profile)) {
            $user_profile = new UserProfile;
        }
        $this->performAjaxValidation($user_profile);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('UserProfile')) {
            $user_profile->attributes = Yii::app()->request->getPost('UserProfile');
            $user_profile->user_id = Yii::app()->user->id;
            if ($user_profile->validate()) {
                if ($user_profile->save()) {
                    Yii::app()->user->setFlash('success', "Personal information edited successfully!!!");
                    $this->redirect(array('accountsetting'));
                }
            }
        }
    }
    
    public function actionEditbillinginformaiton() {
        $model = $this->loadModel(Yii::app()->user->id);
        $user_profile = $model->userProf;
        if (empty($user_profile)) {
            $user_profile = new UserProfile;
        }
        $user_profile->scenario = 'billing_information';
        $this->performAjaxValidation($user_profile);
        
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('UserProfile')) {
            $user_profile->attributes = Yii::app()->request->getPost('UserProfile');
            $user_profile->user_id = Yii::app()->user->id;
            if ($user_profile->validate()) {
                if ($user_profile->save()) {
                    Yii::app()->user->setFlash('success', "Billing information edited successfully!!!");
                    $this->redirect(array('accountsetting'));
                }
            }
        }
    }

    public function actionEditemailaddress() {
        $model = $this->loadModel(Yii::app()->user->id);
        $model->scenario = 'account_setting';
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('User')) {
            $model->attributes = Yii::app()->request->getPost('User');
            $model->user_id = Yii::app()->user->id;
            unset($model->username);
            unset($model->password_hash);
            if ($model->validate()) {
                if ($model->save(false)) {
                    Yii::app()->user->setFlash('success', "Email address edited successfully!!!");
                    $this->redirect(array('accountsetting'));
                }
            }
        }
    }

    public function actionChangepassword() {
        $model = $this->loadModel(Yii::app()->user->id);
        $model->scenario = 'changePwd';
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            unset($model->username);
            unset($model->password_hash);
            $valid = $model->validate();
            if ($valid) {
                $model->password_hash = Myclass::encrypt($model->new_password);
                if ($model->save(false)) {
                    Yii::app()->user->setFlash('success', "Password changed successfully!!!");
                    $this->redirect(array('accountsetting'));
                }
            }
        }
    }

    public function actionEditsecurityquestionanswer() {
        $model = $this->loadModel(Yii::app()->user->id);
        $model->scenario = "account_setting_security";
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('User')) {
            $model->attributes = Yii::app()->request->getPost('User');
            $model->user_id = Yii::app()->user->id;
            unset($model->username);
            unset($model->password_hash);
            if ($model->validate()) {
                if ($model->save(false)) {
                    Yii::app()->user->setFlash('success', "Security question and answer edited successfully!!!");
                    $this->redirect(array('accountsetting'));
                }
            }
        }
    }

    public function actionEditpaypal() {
        $user_paypals = new UserPaypal;
        $this->performAjaxValidation($user_paypals);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('UserPaypal')) {
            $post_data = Yii::app()->request->getPost('UserPaypal');
            $user_paypals = UserPaypal::model()->findByPk($post_data['paypal_id']);
            if (!empty($user_paypals)) {
                $user_paypals->attributes = $post_data;
                $user_paypals->user_id = Yii::app()->user->id;
                if ($user_paypals->validate()) {
                    if ($user_paypals->save(false)) {
                        Yii::app()->user->setFlash('success', "Paypal address edited successfully!!!");
                        $this->redirect(array('accountsetting'));
                    }
                }
            }
        }
    }

    public function actionPaypaldelete($paypal_id) {
        $model = $this->loadModel(Yii::app()->user->id);
        if (UserPaypal::model()->deleteAllByAttributes(array("user_id" => Yii::app()->user->id, "paypal_id" => $paypal_id))) {
            Yii::app()->user->setFlash('success', "paypal address deleted successfully!!!");
            $this->redirect(array('accountsetting'));
        }
    }

    public function actionAccountdeactivate() {
        $user_id = Yii::app()->user->id;
        $user = User::model()->findByPk($user_id);
        $user->status = "3";
        if ($user->save(false)) {
            User::switchStatus(Yii::app()->user->id, 'O');
            Yii::app()->user->logout(false);
            Yii::app()->user->setFlash('success', "You were deactivated your account");
            $this->goHome();
        }
    }

    public function actionAccountdelete() {
        $user_id = Yii::app()->user->id;
        $user = User::model()->findByPk($user_id);
        $user->status = "4";
        if ($user->save(false)) {
            User::switchStatus(Yii::app()->user->id, 'O');
            Yii::app()->user->logout(false);
            Yii::app()->user->setFlash('success', "Your account deleted.");
            $this->goHome();
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * 
     * @param type $model
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function loadModelSlug($slug) {
        $model = User::model()->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionSwitchstatus() {
        if (!empty($_POST['user_id']) && !empty($_POST['mode'])) {
            $model = $this->loadModel($_POST['user_id']);
            $model->saveAttributes(array('live_status' => $_POST['mode']));
        }
        Yii::app()->end();
    }

}
