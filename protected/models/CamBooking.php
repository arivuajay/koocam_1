<?php

/**
 * This is the model class for table "{{cam_booking}}".
 *
 * The followings are the available columns in table '{{cam_booking}}':
 * @property integer $book_id
 * @property string $book_guid
 * @property integer $cam_id
 * @property integer $book_session
 * @property integer $book_user_id
 * @property string $book_date
 * @property string $book_start_time
 * @property string $book_end_time
 * @property string $book_is_extra
 * @property string $book_cam_price
 * @property string $book_extra_price
 * @property string $book_total_price
 * @property string $book_message
 * @property string $book_approve
 * @property string $book_approved_time
 * @property string $book_declined_time
 * @property string $book_payment_status
 * @property string $book_payment_info
 * @property string $created_at
 * @property string $modified_at
 * @property integer $book_duration
 *
 * The followings are the available model relations:
 * @property Cam $cam
 * @property User $bookUser
 * @property CamTokens $camTokens
 * @property ReportAbuse $reportAbuses
 * @property Purchase $camPurchase
 */
class CamBooking extends RActiveRecord {

    public $hours;
    public $minutes;
    public $dist_date;
    public $is_message;

    const CAM_BOOKING_SESSION = 2;
    const HOUR_MIN = 0;
    const HOUR_MAX = 23;
    const MINUTE_MIN = 0;
    const MINUTE_MAX = 59;
    
    const PRE_BOOKING_WAIT = 5;
	const BOOKING_INTERVAL = 10;

    public function init() {
        if ($this->isNewRecord) {
            $this->book_date = date('Y-m-d');
            $this->book_start_time = '';
        }
        parent::init();
    }

    //Tutor Revenue only the user cam price / extra price, Not include the user procession / service fees.
    public function getBeforetaxamount() {
        return $this->book_cam_price + $this->book_extra_price;
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $userID = Yii::app()->user->id;
        $now = date('Y-m-d H:i:s');

        return array(
            'uniqueDays' => array('select' => "DISTINCT(DATE($alias.book_date)) AS `dist_date`"),
            'active' => array('condition' => "$alias.book_approve = '1'"),
            'inactive' => array('condition' => "$alias.book_approve = '0'"),
            'deleted' => array('condition' => "$alias.book_approve = '2'"),
            'all' => array('condition' => "$alias.book_approve is not null"),
            'notdeleted' => array('condition' => "$alias.book_approve != '2'"),
            'completed' => array('condition' => "$alias.book_payment_status = 'C'"),
            'pending' => array('condition' => "$alias.book_payment_status = 'P'"),
            'notExpired' => array('condition' => "$alias.book_end_time >= '{$now}'"),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cam_booking}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cam_id, book_date, book_start_time, book_session', 'required'),
//            array('cam_id, book_date, book_start_time, book_session, minutes, hours', 'required'),
            array('cam_id, book_user_id', 'numerical', 'integerOnly' => true),
            array('book_guid', 'length', 'max' => 50),
            array('book_is_extra, book_approve, book_payment_status', 'length', 'max' => 1),
            array('book_cam_price, book_extra_price, book_total_price', 'length', 'max' => 10),
//            array('hours', 'numerical', 'min' => self::HOUR_MIN, 'max' => self::HOUR_MAX, 'integerOnly' => true),
//            array('minutes', 'numerical', 'min' => self::MINUTE_MIN, 'max' => self::MINUTE_MAX, 'integerOnly' => true),
//            array('hours', 'durationValidate'),
            array('book_start_time', 'bookingValidate'),
//            array('book_start_time', 'date', 'format' => Yii::app()->localtime->getLocalDateTimeFormat('short', 'short')),
            array('book_approved_time, book_payment_info, modified_at, book_session, is_message, book_message, book_declined_time, book_duration', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('book_id, book_guid, cam_id, book_user_id, book_date, book_start_time, book_end_time, book_is_extra, book_cam_price, book_extra_price, book_total_price, book_message, book_approve, book_approved_time, book_payment_status, book_payment_info, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    public function durationValidate($attribute, $params) {
        if ($this->hours == '0') {
            if ($this->minutes == '0')
                $this->addError($attribute, 'Time should not be Zero');
        }
    }

    public function bookingValidate($attribute, $params) {
        if (!empty($this->book_start_time) && !empty($this->cam_id)) {

            $start_time = Yii::app()->localtime->toUTC($this->book_start_time);
            if (!empty($this->cam) && !empty($this->book_session) && $this->book_session > 0):
                $this->setEndtime();
                $end_time = Yii::app()->localtime->toUTC($this->book_end_time);
                $booking_exists = self::checkBooking($start_time, $end_time, $this->cam_id);

                if (!empty($booking_exists))
                    $this->addError($attribute, 'Someone Already booked this Time. Try other timings');
            endif;

            if (strtotime($start_time) <= time()) {
                $this->addError($attribute, 'Time should be greater than Current Time');
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cam' => array(self::BELONGS_TO, 'Cam', 'cam_id'),
            'bookUser' => array(self::BELONGS_TO, 'User', 'book_user_id'),
            'camTokens' => array(self::HAS_ONE, 'CamTokens', 'book_id'),
            'reportAbuses' => array(self::HAS_ONE, 'ReportAbuse', 'book_id'),
            'camPurchase' => array(self::HAS_ONE, 'Purchase', 'book_id'),
            'camComment' => array(self::HAS_ONE, 'CamComments', 'cam_booking_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'book_id' => 'Book',
            'book_guid' => 'Book Guid',
            'cam_id' => 'Cam',
            'book_user_id' => 'User',
            'book_date' => 'Date',
            'book_start_time' => 'Booking Time',
            'book_end_time' => 'End Time',
            'book_is_extra' => 'Is Extra',
            'book_cam_price' => 'Price',
            'book_extra_price' => 'Extra Price',
            'book_total_price' => 'Total Price',
            'book_message' => 'Message',
            'book_approve' => 'Approve',
            'book_approved_time' => 'Approved Time',
            'book_payment_status' => 'Payment Status',
            'book_payment_info' => 'Payment Info',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'book_session' => 'Session',
            'is_message' => 'Is message',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('book_id', $this->book_id);
        $criteria->compare('book_guid', $this->book_guid, true);
        $criteria->compare('cam_id', $this->cam_id);
        $criteria->compare('book_user_id', $this->book_user_id);
        $criteria->compare('book_date', $this->book_date, true);
        $criteria->compare('book_start_time', $this->book_start_time, true);
        $criteria->compare('book_end_time', $this->book_end_time, true);
        $criteria->compare('book_is_extra', $this->book_is_extra, true);
        $criteria->compare('book_cam_price', $this->book_cam_price, true);
        $criteria->compare('book_extra_price', $this->book_extra_price, true);
        $criteria->compare('book_total_price', $this->book_total_price, true);
        $criteria->compare('book_message', $this->book_message, true);
        $criteria->compare('book_approve', $this->book_approve, true);
        $criteria->compare('book_approved_time', $this->book_approved_time, true);
        $criteria->compare('book_payment_status', $this->book_payment_status, true);
        $criteria->compare('book_payment_info', $this->book_payment_info, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CamBooking the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    public static function camSessionPerUser($user_id, $cam_id, $date) {
        $session = self::CAM_BOOKING_SESSION;
        $bookings = self::model()->notdeleted()->findAll("book_user_id = :user_id And cam_id = :cam_id And DATE(book_date) = :date", array(':user_id' => $user_id, ':cam_id' => $cam_id, ':date' => $date));

        $session_count = 0;
        foreach ($bookings as $booking) {
            $session_count += $booking->book_session;
            if ($session_count == $session)
                break;
        }
        return ($session - $session_count);
    }

    public static function camSessionList($user_id, $cam_id, $date) {
        $session_count = self::camSessionPerUser($user_id, $cam_id, $date);
        if ($session_count == 0)
            return array();
        $range = range(1, $session_count);
        return array_combine($range, $range);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->book_guid = Myclass::guid(false);
        }

        if ($this->is_message == 'N')
            $this->book_message = '';

        if ($this->book_approve == '1')
            $this->book_approved_time = date('Y-m-d H:i:s');
        
        $this->book_date = $this->book_start_time;

        return parent::beforeSave();
    }

    protected function beforeValidate() {
        if ($this->is_message == 'Y') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'book_message', array()));
        }

        $this->book_start_time = $this->book_date.' '. $this->book_start_time.':00';
//        $seconds = $this->hours * 3600 + $this->minutes * 60;
//        $this->book_start_time = $this->book_date . ' ' . gmdate("H:i:s", $seconds);
        
        $this->book_date = $this->book_start_time;

        $this->setBookingPrice();

        return parent::beforeValidate();
    }

    protected function afterSave() {
        if ($this->isNewRecord) {
            $this->sendMailtoTutor();
            $this->sendMailtoLearner();
            if ($this->is_message == 'Y' && !empty($this->book_message)) {
                Message::insertMessage($this->book_message, $this->book_user_id, $this->cam->tutor_id, $this->cam_id);
            }
            $user_profile_link = CHtml::link($this->bookUser->fullname, array("/site/user/profile", "slug" => $this->bookUser->slug));
            $cam_link = CHtml::link($this->cam->cam_title, array("/site/cam/view", "slug" => $this->cam->slug));
            $message = "You have a new booking from {$user_profile_link} for your {$cam_link}";
            Notification::insertNotification($this->cam->tutor_id, $message, 'book', $this->book_id);
        }
        return parent::afterSave();
    }

    public function setEndtime() {
        $this->book_end_time = $this->book_start_time;
        $i = 1;
        do {
            $this->book_end_time = date('Y-m-d H:i:s', strtotime("+{$this->cam->cam_duration} minutes", strtotime($this->book_end_time)));
            $i++;
        } while ($i <= $this->book_session);
    }

    public function setBookingPrice() {
        if (!empty($this->cam) && !empty($this->book_session)):
            $cam_price = $this->cam->cam_price;
            $price = 0;
            $book_duration = 0;
            for ($i = 0; $i < $this->book_session; $i++) {
                $price = $cam_price + $price;
                $book_duration = $book_duration + $this->cam->cam_duration;
            }
            $this->book_cam_price = $price;
            $this->book_duration = $book_duration;

            $this->book_extra_price = 0;
            if ($this->book_is_extra)
                $this->book_extra_price = $this->cam->camExtras->extra_price;

            $price_calculation = self::price_calculation(Yii::app()->user->country_id, $this->book_cam_price, $this->book_extra_price);
            $this->book_processing_fees = $price_calculation['processing_fees'];
            $this->book_service_tax = $price_calculation['service_tax'];
            $this->book_total_price = $price_calculation['total_price'];
            
        endif;
    }

    public function sendMailtoTutor() {
        $tutor = $this->cam->tutor;
        $learner = $this->bookUser;
        $book_date = date(PHP_SHORT_DATE_FORMAT, strtotime($this->book_date));

        $mail = new Sendmail;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $tutor->fullname,
            "{EMAIL_ID}" => $tutor->email,
            "{LEARNER}" => $learner->fullname,
            "{CAM}" => $this->cam->cam_title,
            "{BOOK_DATE}" => $book_date,
            "{FROM_TIME}" => date('H:i', strtotime(Yii::app()->localtime->fromUTC($this->book_start_time))),
            "{TO_TIME}" => date('H:i', strtotime(Yii::app()->localtime->fromUTC($this->book_end_time))),
        );
        $message = $mail->getMessage('cam_booking_tutor', $trans_array);
        $Subject = $mail->translate("New Booking For Your CAM ({$this->cam->cam_title})");
        $mail->send($tutor->email, $Subject, $message);
    }
    
    public function sendMailtoLearner() {
        $tutor = $this->cam->tutor;
        $learner = $this->bookUser;
        $book_date = date(PHP_SHORT_DATE_FORMAT, strtotime($this->book_date));
        
        $mail = new Sendmail;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $learner->fullname,
            "{EMAIL_ID}" => $learner->email,
            "{TUTOR}" => $tutor->fullname,
            "{CAM}" => $this->cam->cam_title,
            "{BOOK_DATE}" => $book_date,
            "{FROM_TIME}" => date('H:i', strtotime(Yii::app()->localtime->fromUTC($this->book_start_time))),
            "{TO_TIME}" => date('H:i', strtotime(Yii::app()->localtime->fromUTC($this->book_end_time))),
            "{BOOK_URL}" => Yii::app()->createAbsoluteUrl("/site/cambooking/prebooking", array("book_guid" => $this->book_guid)),
        );
        $message = $mail->getMessage('cam_booking_learner', $trans_array);
        $Subject = $mail->translate("New Booking For CAM ({$this->cam->cam_title})");
        $mail->send($learner->email, $Subject, $message);
    }

    public static function checkBooking($start_time, $end_time, $cam_id) {
//        $end_time = date('Y-m-d H:i:s', strtotime($end_time).' +'.self::BOOKING_INTERVAL.' minutes');
        
        $alias = self::model()->getTableAlias(false, false);
        $condition = "(($alias.book_start_time <= :start_time And $alias.book_end_time >= :start_time)";
        $condition .= " OR ($alias.book_start_time <= :end_time And $alias.book_end_time >= :end_time)) ";
        $condition .= " And $alias.cam_id = :cam_id";

        return self::model()->active()->findAll(array(
                    'condition' => $condition,
                    'params' => array(':start_time' => $start_time, ':end_time' => $end_time, ':cam_id' => $cam_id)
        ));
    }

    public function getUserviewlink($htmlOptions = array()) {
        echo CHtml::link($this->bookUser->fullname, array('/admin/user/view', 'id' => $this->book_user_id), $htmlOptions);
    }

    public static function price_calculation($user_country_id, $cam_price, $extra_price = 0) {
        $return = array();

        $total_price = $cam_price + $extra_price;
        $return['processing_fees'] = $total_price * (PROCESSING_FEE_PERCENT / 100);
        $return['service_tax'] = 0;
        if ($user_country_id == DEFAULT_COUNTRY) {
            $return['service_tax'] = $total_price * (SERVICE_TAX_PERCENT / 100);
        }

        $return['total_price'] = $total_price + $return['processing_fees'] + $return['service_tax'];
        return $return;
    }

}
