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
    
    const GIG_BOOKING_SESSION = 2;

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
            array('book_guid, gig_id, book_user_id, book_date, book_start_time, book_end_time, book_message, book_session', 'required'),
            array('gig_id, book_user_id', 'numerical', 'integerOnly' => true),
            array('book_guid', 'length', 'max' => 50),
            array('book_is_extra, book_approve, book_payment_status', 'length', 'max' => 1),
            array('book_gig_price, book_extra_price, book_total_price', 'length', 'max' => 10),
            array('book_approved_time, book_payment_info, modified_at, book_session', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('book_id, book_guid, gig_id, book_user_id, book_date, book_start_time, book_end_time, book_is_extra, book_gig_price, book_extra_price, book_total_price, book_message, book_approve, book_approved_time, book_payment_status, book_payment_info, created_at, modified_at', 'safe', 'on' => 'search'),
        );
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
            'book_user_id' => 'Book User',
            'book_date' => 'Book Date',
            'book_start_time' => 'Book Start Time',
            'book_end_time' => 'Book End Time',
            'book_is_extra' => 'Book Is Extra',
            'book_gig_price' => 'Book Gig Price',
            'book_extra_price' => 'Book Extra Price',
            'book_total_price' => 'Book Total Price',
            'book_message' => 'Book Message',
            'book_approve' => 'Book Approve',
            'book_approved_time' => 'Book Approved Time',
            'book_payment_status' => 'Book Payment Status',
            'book_payment_info' => 'Book Payment Info',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
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
        $booking = self::model()->countByAttributes(array('book_user_id' => $user_id, 'gig_id' => $gig_id, 'book_date' => $date));
        return ($session - $booking);
    }
}
