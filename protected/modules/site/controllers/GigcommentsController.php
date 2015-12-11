<?php

/**
 * Site controller
 */
class GigcommentsController extends Controller {

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    public function actionCreate() {
        $model = new GigComments();
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('GigComments')) {
            $model->attributes = Yii::app()->request->getPost('GigComments');
            $model->user_id = Yii::app()->user->id;
            if ($model->save()) {
                $message = "{$model->user->fullname} Commented on your Gig ({$model->gig->gig_title})";
                Notification::insertNotification($model->gig->tutor_id, $message);
                Yii::app()->user->setFlash('success', "Your comment sent successfully!!!.");
            } else {
                Yii::app()->user->setFlash('danger', "Sorry, comment not sent. Please try again.");
            }
            $this->redirect(array('/site/purchase/mypurchase'));
//            $this->redirect(array('/site/gig/view', 'slug' => $model->gig->slug));
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
        $model = GigComments::model()->findByPk($id);
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

}
