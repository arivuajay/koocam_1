<?php

/**
 * Site controller
 */
class BookingtempController extends Controller {

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
                'actions' => array('paypalreturn', 'paypalcancel', 'paypalnotify'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('booking'),
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
        $booking_temp = new BookingTemp();
        $this->performAjaxValidation($booking_temp);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('BookingTemp')) {
            $post_data = Yii::app()->request->getPost('BookingTemp');

            $gig = Gig::model()->findByPk($post_data['temp_gig_id']);

            $data = array();
            $data = $post_data;
            $data['temp_book_user_id'] = Yii::app()->user->id;
            $data['temp_book_gig_price'] = $gig->gig_price;
            $data['temp_book_total_price'] = $gig->gig_price;
            $data['temp_book_duration'] = $gig->gig_duration;

            if ($post_data['temp_book_session'] == 2) {
                $data['temp_book_gig_price'] = 2 * $gig->gig_price;
                $data['temp_book_total_price'] = 2 * $gig->gig_price;
            }

            if ($post_data['temp_book_is_extra'] == "Y") {
                $data['temp_book_extra_price'] = $gig->gigExtras->extra_price;
                $data['temp_book_total_price'] = $data['temp_book_total_price'] + $data['temp_book_extra_price'];
            }

            $booking_temp->temp_value = serialize($data);

            if ($booking_temp->save(false)) {
                $paypalManager = new Paypal;
                $returnUrl = Yii::app()->createAbsoluteUrl('/site/bookingtemp/paypalreturn', array('slug' => $gig->slug));
                $cancelUrl = Yii::app()->createAbsoluteUrl('/site/bookingtemp/paypalcancel', array('slug' => $gig->slug));
                $notifyUrl = Yii::app()->createAbsoluteUrl('/site/bookingtemp/paypalnotify');

                $paypalManager->addField('item_name', $gig->gig_title . '-' . BookingTemp::TEMP_BOOKING_KEY);
                $paypalManager->addField('amount', $data['temp_book_total_price']);
                $paypalManager->addField('custom', $booking_temp->temp_guid);
                $paypalManager->addField('return', $returnUrl);
                $paypalManager->addField('cancel_return', $cancelUrl);
                $paypalManager->addField('notify_url', $notifyUrl);

                $paypalManager->submitPaypalPost();
            }
        }
    }

    public function actionPaypalcancel($slug) {
        Yii::app()->user->setFlash('danger', 'Your booking has been cancelled. Please try again.');
        $this->redirect(array('/site/gig/view', 'slug' => $slug));
    }

    public function actionPaypalreturn($slug) {
        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($_POST["payment_status"] == "Pending" || $_POST["payment_status"] == "Completed") {
                $booking_temp = BookingTemp::model()->findByAttributes(array('temp_guid' => $_POST['custom']));
                $booking_data = unserialize($booking_temp->temp_value);

                $book_guid = isset($booking_data['book_guid']) ? $booking_data['book_guid'] : '';
                if ($book_guid) {
                    $booking_temp->delete();
                    Yii::app()->user->setFlash('success', 'Thanks for your booking!');
                    $this->redirect(array('/site/default/chat', 'guid' => $book_guid));
                } else {
                    Yii::app()->user->setFlash('danger', 'Failed to generate token.');
                }
            }
        } else {
            Yii::app()->user->setFlash('danger', 'Your booking payment is failed. Please try again later or contact admin.');
        }
        $this->redirect(array('/site/gig/view', 'slug' => $slug));
    }

    public function actionPaypalnotify() {
//        $paypalManager = new Paypal;
//        if ($paypalManager->notify()) {
        if ($_POST["payment_status"] == "Pending" || $_POST["payment_status"] == "Completed") {
            $this->processBooking($_POST['custom']);
        }
//        }
    }

    protected function processBooking($temp_guid) {
        $booking_temp = BookingTemp::model()->findByAttributes(array('temp_guid' => $temp_guid));
        if (!empty($booking_temp)) {
            $booking_data = unserialize($booking_temp->temp_value);
            $booking_model = new GigBooking();

            foreach ($booking_data as $key => $value) {
                $attr_name = str_replace('temp_', '', $key);
                $booking_model->setAttribute($attr_name, $value);
            }

            $booking_model->book_date = date("Y-m-d H:i:s");
            $booking_model->book_start_time = date("Y-m-d H:i:s");
            $booking_model->setEndtime();
            $booking_model->book_payment_status = "C";
            $booking_model->book_payment_info = serialize($_POST);

            if ($booking_model->save(false)) {
                $booking_data['book_guid'] = $booking_model->book_guid;
                $booking_temp->temp_value = serialize($booking_data);
                $booking_temp->save(false);
                GigTokens::generateToken($booking_model->book_guid);
                Transaction::bookingTransaction($booking_model->book_id);
                Purchase::insertPurchase($booking_model->book_id);
            }
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
        $model = BookingTemp::model()->findByPk($id);
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
