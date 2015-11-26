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
                'actions' => array('profileupdate'),
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
        $this->render('profile', compact('model', 'user_profile'));
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

}
