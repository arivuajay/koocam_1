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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('booking', 'calendarevents', 'getsessionoptions'),
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

            if ($post_data['temp_book_is_extra'] == "Y") {
                $data['temp_book_extra_price'] = $gig->gigExtras->extra_price;
                $data['temp_book_total_price'] = $gig->gig_price + $gig->gigExtras->extra_price;
            }

            $booking_temp->temp_value = serialize($data);

            if ($booking_temp->save(false)) {
//                $paypalManager = new Paypal;
//                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalReturn'));
//                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalCancel'));
//                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalNotify'));
//
//                $paypalManager->addField('item_name', RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT);
//                $paypalManager->addField('amount', $data['price_list']['total_price']);
////                $paypalManager->addField('quantity', $no_of_accounts_purchase);
//                $paypalManager->addField('tax', $data['price_list']['tax']);
//                $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
//                $paypalManager->addField('return', $returnUrl);
//                $paypalManager->addField('cancel_return', $cancelUrl);
//                $paypalManager->addField('notify_url', $notifyUrl);
//
//                $paypalManager->submitPaypalPost();
            }

//            if ($booking_model->save()) {
//                Yii::app()->user->setFlash('success', "Your Booking sent for approval.");
//                $this->redirect(array('/site/gig/view', 'slug' => $booking_model->gig->slug));
//            }
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
