<?php

class ContactusController extends Controller {
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
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Contactus('search');
        $new_model = new Contactus('admin');
        $is_post = Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Contactus');
        if ($is_post) {
            $post_data = Yii::app()->request->getPost('Contactus');
            
            if (isset($post_data['contact_id'])) {
                $new_model = $this->loadModel($post_data['contact_id']);
                $new_model->scenario = 'admin';
            }
        }
        
        $this->performAjaxValidation($new_model);
        if ($is_post) {
            $new_model->attributes = $post_data;
            if ($new_model->save(false)) {
                $mail = new Sendmail;
                $trans_array = array(
                    "{SITENAME}" => SITENAME,
                    "{USERNAME}" => $new_model->contact_name,
                    "{REPLY}" => $new_model->contact_reply,
                );
                $message = $mail->getMessage('contact_us_reply', $trans_array);
                $Subject = $mail->translate(SITENAME . ": Reply for your contact request");
                $mail->send($new_model->contact_email, $Subject, $message);
                
                Yii::app()->user->setFlash('success', "Your Reply sent Successfully");
            } else {
                Yii::app()->user->setFlash('danger', "Failed to save");
            }
            $this->refresh();
        }
         
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contactus'])) {
            $model->attributes = $_GET['Contactus'];
        }

        $this->render('index', compact('model', 'new_model'));
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
        $model = new Contactus;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Contactus')) {
            $model->attributes = Yii::app()->request->getPost('Contactus');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Contactus Created Successfully!!!');
                $this->redirect(array('/admin/contactus/index'));
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

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Contactus')) {
            $model->attributes = Yii::app()->request->getPost('Contactus');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Contactus Updated Successfully!!!');
                $this->redirect(array('/admin/contactus/index'));
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
            Yii::app()->user->setFlash('success', 'Contactus Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/contactus/index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Contactus the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Contactus::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Contactus $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
