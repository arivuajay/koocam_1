<?php

/**
 * This is the model class for table "{{gig_booking}}".
 *
 * The followings are the available columns in table '{{gig_booking}}':
 * @property integer $book_id
 * @property string $book_guid
 * @property integer $gig_id
 * @property integer $book_session
 * @property integer $book_user_id
 * @property string $book_date
 * @property string $book_start_time
 * @property string $book_end_time
 * @property string $book_is_extra
 * @property string $book_gig_price
 * @property string $book_extra_price
 * @property string $book_total_price
 * @property string $book_message
 * @property string $book_approve
 * @property string $book_approved_time
 * @property string $book_payment_status
 * @property string $book_payment_info
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Gig $gig
 * @property User $bookUser
 */
class GigBooking extends RActiveRecord {

    public $hours;
    public $minutes;
    public $dist_date;
    public $is_message;

    const GIG_BOOKING_SESSION = 2;
    const HOUR_MIN = 0;
    const HOUR_MAX = 23;
    const MINUTE_MIN = 0;
    const MINUTE_MAX = 59;

    public function init() {
        if ($this->isNewRecord) {
            $this->book_date = date('Y-m-d');
            $this->book_start_time = '';
        }
        parent::init();
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $userID = Yii::app()->user->id;
        return array(
            'uniqueDays' => array('select' => "DISTINCT(DATE($alias.book_date)) AS `dist_date`"),
            'active' => array('condition' => "$alias.book_approve = '1'"),
            'inactive' => array('condition' => "$alias.book_approve = '0'"),
            'deleted' => array('condition' => "$alias.book_approve = '2'"),
            'all' => array('condition' => "$alias.book_approve is not null"),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gig_booking}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gig_id, book_date, book_start_time, book_session, minutes, hours', 'required'),
            array('gig_id, book_user_id', 'numerical', 'integerOnly' => true),
            array('book_guid', 'length', 'max' => 50),
            array('book_is_extra, book_approve, book_payment_status', 'length', 'max' => 1),
            array('book_gig_price, book_extra_price, book_total_price', 'length', 'max' => 10),
            array('hours', 'numerical', 'min' => self::HOUR_MIN, 'max' => self::HOUR_MAX, 'integerOnly' => true),
            array('minutes', 'numerical', 'min' => self::MINUTE_MIN, 'max' => self::MINUTE_MAX, 'integerOnly' => true),
            array('hours', 'durationValidate'),
            array('book_start_time', 'bookingValidate'),
//            array('book_start_time', 'date', 'format' => Yii::app()->localtime->getLocalDateTimeFormat('short', 'short')),
            array('book_approved_time, book_payment_info, modified_at, book_session, is_message, book_message', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('book_id, book_guid, gig_id, book_user_id, book_date, book_start_time, book_end_time, book_is_extra, book_gig_price, book_extra_price, book_total_price, book_message, book_approve, book_approved_time, book_payment_status, book_payment_info, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    public function durationValidate($attribute, $params) {
        if ($this->hours == '0') {
            if ($this->minutes == '0')
                $this->addError($attribute, 'Time should not be Zero');
        }
    }

    public function bookingValidate($attribute, $params) {
        if (!empty($this->book_start_time)) {

            if (!empty($this->gig) && !empty($this->book_session) && $this->book_session > 0):
                $this->setEndtime();
            
                $start_time = Yii::app()->localtime->toUTC($this->book_start_time);
                $end_time = Yii::app()->localtime->toUTC($this->book_end_time);
                $booking_exists = self::checkBooking($start_time, $end_time);

                if (!empty($booking_exists))
                    $this->addError($attribute, 'Someone Already booked this Time. Try other timings');
            endif;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gig' => array(self::BELONGS_TO, 'Gig', 'gig_id'),
            'bookUser' => array(self::BELONGS_TO, 'User', 'book_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'book_id' => 'Book',
            'book_guid' => 'Book Guid',
            'gig_id' => 'Gig',
            'book_user_id' => 'User',
            'book_date' => 'Date',
            'book_start_time' => 'Booking Time',
            'book_end_time' => 'End Time',
            'book_is_extra' => 'Is Extra',
            'book_gig_price' => 'Price',
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
        $criteria->compare('gig_id', $this->gig_id);
        $criteria->compare('book_user_id', $this->book_user_id);
        $criteria->compare('book_date', $this->book_date, true);
        $criteria->compare('book_start_time', $this->book_start_time, true);
        $criteria->compare('book_end_time', $this->book_end_time, true);
        $criteria->compare('book_is_extra', $this->book_is_extra, true);
        $criteria->compare('book_gig_price', $this->book_gig_price, true);
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
     * @return GigBooking the static model class
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

    public static function gigSessionPerUser($user_id, $gig_id, $date) {
        $session = self::GIG_BOOKING_SESSION;
        $bookings = self::model()->findAllByAttributes(array('book_user_id' => $user_id, 'gig_id' => $gig_id, 'book_date' => $date));

        $session_count = 0;
        foreach ($bookings as $booking) {
            $session_count += $booking->book_session;
        }
        return ($session - $session_count);
    }

    public static function gigSessionList($user_id, $gig_id, $date) {
        $session_count = self::gigSessionPerUser($user_id, $gig_id, $date);
        if ($session_count == 0)
            return array();
        $range = range(1, $session_count);
        return array_combine($range, $range);
    }

    protected function beforeSave() {
        if ($this->isNewRecord)
            $this->book_guid = Myclass::guid(false);

        if ($this->is_message == 'N')
            $this->book_message = '';
        
        echo '<pre>';
        print_r($this->attributes);
        exit;

        return parent::beforeSave();
    }

    protected function beforeValidate() {
        if ($this->is_message == 'Y') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'book_message', array()));
        }

        $seconds = $this->hours * 3600 + $this->minutes * 60;
        $this->book_start_time = $this->book_date . ' ' . gmdate("H:i:s", $seconds);

        if (!empty($this->gig)):
            $this->book_gig_price = $this->gig->gig_price;
            if ($this->book_is_extra)
                $this->book_extra_price = $this->gig->gigExtras->extra_price;
            $this->book_total_price = $this->gig->gig_price + $this->book_extra_price;
        endif;
        $this->book_date = $this->book_date . ' 00:00:00';

        return parent::beforeValidate();
    }

    protected function afterSave() {
        if ($this->isNewRecord) {
            $this->sendMailtoTutor();
            $this->insertNotification();
        }
        return parent::afterSave();
    }

    public function setEndtime() {
        $this->book_end_time = $this->book_start_time;
        $i = 1;
        do {
            $this->book_end_time = date('Y-m-d H:i:s', strtotime("+{$this->gig->gig_duration} minutes", strtotime($this->book_end_time)));
            $i++;
        } while ($i <= $this->book_session);
    }

    public function insertNotification() {
        $notifn_model = new Notification();
        $notifn_model->user_id = $this->gig->tutor->user_id;
        $notifn_model->notifn_type = 'book';
        $notifn_model->notifn_rel_id = $this->book_id;

        if ($this->book_message == '') {
            $message = "You have a new booking from {$this->bookUser->fullname}";
        } else {
            $message = $this->book_message;
        }
        $notifn_model->notifn_message = $message;
        $notifn_model->save(false);
    }

    public function sendMailtoTutor() {
        $tutor = $this->gig->tutor;
        $learner = $this->bookUser;
        $book_date = date(PHP_SHORT_DATE_FORMAT, strtotime($this->book_date));

        $mail = new Sendmail;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $tutor->fullname,
            "{EMAIL_ID}" => $tutor->email,
            "{LEARNER}" => $learner->fullname,
            "{GIG}" => $this->gig->gig_title,
            "{BOOK_DATE}" => $book_date,
            "{FROM_TIME}" => date('H:i', strtotime($this->book_start_time)),
            "{TO_TIME}" => date('H:i', strtotime($this->book_end_time)),
        );
        $message = $mail->getMessage('gig_booking_tutor', $trans_array);
        $Subject = $mail->translate("New Booking For Your GIG ({$this->gig->gig_title})");
        $mail->send($tutor->email, $Subject, $message);
    }

    public static function checkBooking($start_time, $end_time) {
        $alias = self::model()->getTableAlias(false, false);
        $condition = "(($alias.book_start_time <= :start_time And $alias.book_end_time >= :start_time)";
        $condition .= " OR ($alias.book_start_time <= :end_time And $alias.book_end_time >= :end_time)) ";
        $condition .= " And $alias.book_approve = '1'";

        return self::model()->findAll(array(
            'condition' => $condition,
            'params' => array(':start_time' => $start_time, ':end_time' => $end_time)
        ));
    }

}
