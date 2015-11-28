<?php

/**
 * Site controller
 */
class GigbookingController extends Controller {

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
                'actions' => array('booking', 'calendarevents'),
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
    public function actionBooking() {
        $booking_model = new GigBooking();
        $this->performAjaxValidation($booking_model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('GigBooking')) {
            $booking_model->attributes = Yii::app()->request->getPost('GigBooking');
            $booking_model->book_user_id = Yii::app()->user->id;

            if ($booking_model->save()) {
                Yii::app()->user->setFlash('success', "Your Booking sent for approval.");
                $this->redirect(array('/site/gig/view', 'slug' => $booking_model->gig->slug));
            }
        }
    }

    public function actionCalendarevents() {
        $bookings = GigBooking::model()->active()->findAll(array('order' => 'created_at DESC'));
        $limit = 10;
        $date = array();
        foreach ($bookings as $booking) {
            if (isset($date[strtotime($booking->book_date)])) {
                $date[strtotime($booking->book_date)] = $date[strtotime($booking->book_date)] + 1;
            } else {
                $date[strtotime($booking->book_date)] = 1;
            }

            if ($date[strtotime($booking->book_date)] <= $limit) {
                $items[] = array(
                    'state' => 'TRUE',
                    'title' => 'Booked',
                    'start' => date('Y-m-d', strtotime($booking->book_date)),
                    'color' => '#95e5e7',
                    //                'start' => $booking->book_date,
                    'url' => $this->createUrl('/site/journal/listjournal', array('date' => date('Y-m-d', strtotime($booking->book_date))))
                );
            }
        }

        echo CJSON::encode($items);
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = GigBooking::model()->findByPk($id);
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
        $model = GigBooking::model()->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
