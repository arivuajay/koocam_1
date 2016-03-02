<?php

class PurchaseController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'changereceiptstatus'),
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
        $model = new Purchase('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Purchase'])) {
            $model->attributes = $_GET['Purchase'];
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
        $model = new Purchase;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Purchase')) {
            $model->attributes = Yii::app()->request->getPost('Purchase');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Purchase Created Successfully!!!');
                $this->redirect(array('/admin/purchase/index'));
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

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Purchase')) {
            $model->attributes = Yii::app()->request->getPost('Purchase');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Purchase Updated Successfully!!!');
                $this->redirect(array('/admin/purchase/index'));
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
        $purchase = $this->loadModel($id);
        $camBooking = $purchase->book;

        if ($camBooking->camTokens->tutor_attendance == '0' || $camBooking->camTokens->learner_attendance == '0') {
            $transaction = Transaction::model()->deleteAll('book_id = :book_id', array(":book_id" => $camBooking->book_id));
            $purchase->delete();
            $camBooking->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Purchase Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/purchase/index'));
        }
    }

    public function actionChangereceiptstatus() {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Purchase')) {
            $post = Yii::app()->request->getPost('Purchase');
            $purchase = $this->loadModel($post['purchase_id']);
            $purchase->receipt_status = '1';
            $purchase->save(false);
            Yii::app()->user->setFlash('success', 'Updated Successfully!!!');
            $this->redirect(array('/admin/purchase/index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Purchase the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Purchase::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Purchase $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchase-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
