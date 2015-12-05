<?php

class TransactionController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'cashwithdraw'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Transaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Transaction'])) {
            $model->attributes = $_GET['Transaction'];
        }

        $this->render('index', compact('model'));
    }

    public function actionCashwithdraw() {
        $model = new Transaction('approve');
        $is_post = Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Transaction');
        if ($is_post) {
            $post_data = Yii::app()->request->getPost('Transaction');
            
            if (isset($post_data['trans_id'])) {
                $model = $this->loadModel($post_data['trans_id']);
                if($post_data['status'] == '1')
                    $model->scenario = 'approve';
                else if($post_data['status'] == '2')
                    $model->scenario = 'reject';
            }
        }
        $this->performAjaxValidation($model);

        if ($is_post) {
            $model->attributes = $post_data;
            if ($model->save(false)) {
                if($model->status == '1')
                    $model->cashApprove();
                else if($model->status == '2')
                    $model->cashReject();
                
                Yii::app()->user->setFlash('success', "Withdraw Approved Successfully");
            } else {
                Yii::app()->user->setFlash('danger', "Failed to save");
            }
            $this->refresh();
        }

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Transaction'])) {
            $model->attributes = $_GET['Transaction'];
        }
        $model->trans_type = 'W';

        $this->render('cashwithdraw', compact('model'));
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
        $model = new Transaction;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Transaction')) {
            $model->attributes = Yii::app()->request->getPost('Transaction');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Transaction Created Successfully!!!');
                $this->redirect(array('/admin/transaction/index'));
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

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Transaction')) {
            $model->attributes = Yii::app()->request->getPost('Transaction');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Transaction Updated Successfully!!!');
                $this->redirect(array('/admin/transaction/index'));
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
            Yii::app()->user->setFlash('success', 'Transaction Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/transaction/index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Transaction the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Transaction::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Transaction $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
