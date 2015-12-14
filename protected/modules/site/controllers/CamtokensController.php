<?php

/**
 * Site controller
 */
class CamtokensController extends Controller {

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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('generatetoken'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    /**
     * 
     */
    public function actionGeneratetoken($guid) {
        $booking_model = CamBooking::model()->findByAttributes(array('book_guid' => $guid, 'book_approve' => '1'));
        if (!empty($booking_model)) {
            if (!empty($booking_model)) {
                $token_exists = CamTokens::model()->findByAttributes(array('book_id' => $booking_model->book_id));

                if (empty($token_exists)) {
                    $token_model = new CamTokens;
                    $role = CamTokens::TOKEN_ROLE;
                    $expire = time() + ($booking_model->cam->cam_duration * 60);
                    $session_data = array(
                        'expire' => $expire,
                        'role' => $role,
                    );

                    $session_key = Yii::app()->tok->createSession()->id;
                    $token_key = Yii::app()->tok->generateToken($session_key, $role, $expire);

                    $token_model->attributes = array(
                        'book_id' => $booking_model->book_id,
                        'session_key' => $session_key,
                        'token_key' => $token_key,
                        'session_data' => $session_data,
                    );
                    $token_model->save();
                }
            }
        }
        return true;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CamTokens::model()->findByPk($id);
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
