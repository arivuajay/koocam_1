<?php

/**
 * Site controller
 */
class NotificationController extends Controller {

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
                'actions' => array('view', 'index', 'approve', 'decline', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    public function actionIndex() {
        $this->layout = '//layouts/user_dashboard';
        
        $model = new Notification();
        $criteria = new CDbCriteria;
        $alias = $model->getTableAlias(false, false);
        $criteria->compare($alias . '.user_id', Yii::app()->user->id);
        $criteria->order = 'created_at DESC';

        $pages = new CPagination(Notification::model()->count($criteria));
        $pages->pageSize = Notification::NOTIFICATION_INDEX_LIMIT;
        $pages->applyLimit($criteria);
        $results = Notification::model()->findAll($criteria);

        foreach ($results as $notifn) {
            if($notifn->notifn_read == 'N'){
                $notifn_model = $this->loadModel($notifn->notifn_id);
                $notifn_model->saveAttributes(array('notifn_read' => 'Y'));
            }
        }
        $this->render('index', compact('results', 'pages'));
    }
    /**
     * 
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', compact('model'));
    }

    public function actionApprove($id) {
        $model = $this->loadModel($id);
        
        if($model->user_id != Yii::app()->user->id || empty($model->camBooking)){
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        
        $booking = $model->camBooking;
        $start_time = Yii::app()->localtime->toUTC($booking->book_start_time);
        $end_time = Yii::app()->localtime->toUTC($booking->book_end_time);
        $booking_exists = CamBooking::checkBooking($start_time, $end_time);
        
        if(empty($booking_exists)){
            $booking->saveAttributes(array('book_approve' => '1', 'book_approved_time' => Yii::app()->localtime->UTCNow));
            Yii::app()->user->setFlash('success', "Booking Approved successfully");
        }else{
            Yii::app()->user->setFlash('danger', "Someone Already booked at this timing !!!");
        }
        $this->redirect(array('/site/notification'));
    }

    public function actionDecline($id) {
        $model = $this->loadModel($id);
        
        if($model->user_id != Yii::app()->user->id || empty($model->camBooking)){
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        
        $booking = $model->camBooking;
        $booking->saveAttributes(array('book_approve' => '2', 'book_declined_time' => Yii::app()->localtime->UTCNow));
        Yii::app()->user->setFlash('success', "Booking Rejected successfully");
        $this->redirect(array('/site/notification'));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);

        if($model->user_id != Yii::app()->user->id){
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $model->delete();
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])){
            Yii::app()->user->setFlash('success', 'Notification Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/site/notification/index'));
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
        $model = Notification::model()->findByPk($id);
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
