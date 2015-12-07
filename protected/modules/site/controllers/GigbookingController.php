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
                'actions' => array('booking', 'calendarevents', 'getsessionoptions', 'getbookingprice'),
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

            $valid = $booking_model->validate();
            if ($valid) {
                $booking_model->book_start_time = Yii::app()->localtime->toUTC($booking_model->book_start_time);
                $booking_model->book_end_time = Yii::app()->localtime->toUTC($booking_model->book_end_time);

                $valid = $valid && $booking_model->save(false);
                if ($valid)
                    Yii::app()->user->setFlash('success', "Your Booking Confirmed.");
                else
                    Yii::app()->user->setFlash('danger', "Some error occurs. Try again");
                $this->redirect(array('/site/gig/view', 'slug' => $booking_model->gig->slug));
            }
        }
    }

    public function actionCalendarevents($gig) {
        $bookings = GigBooking::model()->active()->findAll(array('order' => 'created_at DESC', 'condition' => "gig_id = {$gig}"));
//        $limit = 10;
        $date = array();
        foreach ($bookings as $booking) {
//            if (isset($date[strtotime($booking->book_date)])) {
//                $date[strtotime($booking->book_date)] = $date[strtotime($booking->book_date)] + 1;
//            } else {
//                $date[strtotime($booking->book_date)] = 1;
//            }
//            if ($date[strtotime($booking->book_date)] <= $limit) {
            $title = 'Busy (' . date('H:i', strtotime($booking->book_start_time)) . '-' . date('H:i', strtotime($booking->book_end_time)) . ')';
            $items[] = array(
                'state' => 'TRUE',
                'title' => $title,
                'start' => date('Y-m-d', strtotime($booking->book_date)),
                'color' => '#7E7E7E',
                    //                'start' => $booking->book_date,
//                    'url' => $this->createUrl('/site/journal/listjournal', array('date' => date('Y-m-d', strtotime($booking->book_date))))
            );
//            }
        }

        echo CJSON::encode($items);
        Yii::app()->end();
    }

    public function actionGetsessionoptions() {
        $options = '<option value="">Select Session</option>';
        if (isset($_POST)) {
            $session_count = GigBooking::gigSessionList($_POST['user_id'], $_POST['gig_id'], $_POST['date']);
            if (!empty($session_count)) {
                foreach ($session_count as $val) {
                    $options .= "<option value='$val'>$val</option>";
                }
            }
        }
        echo $options;
        Yii::app()->end();
    }

    public function actionGetbookingprice() {
        if (isset($_POST)) {
            $result = GigBooking::price_calculation($_POST['user_country_id'], $_POST['gig_price'], $_POST['extra_price']);
            echo CJSON::encode($result);
        }
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
