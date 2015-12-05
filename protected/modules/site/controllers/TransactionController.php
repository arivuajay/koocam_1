<?php

/**
 * Transaction controller
 */
class TransactionController extends Controller {

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
                'actions' => array('mypayments', 'withdraw'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    public function actionMypayments() {
        $this->layout = '//layouts/user_dashboard';

        $model = new Transaction('withdraw');

        $this->render('mypayments', compact('model'));
    }

    public function actionWithdraw() {
        $model = new Transaction('withdraw');
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Transaction')) {
            $model->attributes = Yii::app()->request->getPost('Transaction');
            $model->user_id = Yii::app()->user->id;
            $model->trans_type = 'W';
            if ($model->validate()) {
                if ($model->save(false)) {
                    $model->cashwithdrawMail();
                    Yii::app()->user->setFlash('success', "Request Sent Successfully. We will get back to you soon.");
                } else {
                    Yii::app()->user->setFlash('danger', "Failed to send request. Try again later");
                }
                $this->redirect(array('/site/transaction/mypayments'));
            }
        }
        $this->render('mypayments', compact('model'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Transaction::model()->findByPk($id);
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
