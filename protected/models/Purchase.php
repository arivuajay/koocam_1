<?php

/**
 * This is the model class for table "{{purchase}}".
 *
 * The followings are the available columns in table '{{purchase}}':
 * @property integer $purchase_id
 * @property string $order_id
 * @property integer $book_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property User $user
 * @property CamBooking $book
 */
class Purchase extends RActiveRecord {
    
    public $booking_date;
    public $booking_duration;
    public $booking_session;

    //PAGE LIMIT
    const MY_PURCHASE_LIMIT = 9;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{purchase}}';
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $user_id = Yii::app()->user->id;

        return array(
            'mine' => array('condition' => "$alias.user_id = $user_id"),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('book_id, user_id, order_id', 'required'),
            array('book_id, user_id', 'numerical', 'integerOnly' => true),
            array('created_at, modified_at, order_id, booking_date, booking_duration, booking_session, receipt_status', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('purchase_id, book_id, user_id, created_at, modified_at, order_id, booking_date, booking_duration, booking_session', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'book' => array(self::BELONGS_TO, 'CamBooking', 'book_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'purchase_id' => 'Purchase',
            'order_id' => 'Purchase ID',
            'book_id' => 'Book',
            'user_id' => 'User',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'receipt_status' => 'Receipt Status',
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
        $criteria->with = array( 'book' );
        $alias = $this->getTableAlias(false, false);

        $criteria->compare('purchase_id', $this->purchase_id);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('book_id', $this->book_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        
        $criteria->compare('book.book_date', $this->booking_date, true);
        $criteria->compare('book.book_duration', $this->booking_duration);
        $criteria->compare('book.book_session', $this->booking_session);

        $criteria->order = "{$alias}.created_at DESC";

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
     * @return Purchase the static model class
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

    public static function insertPurchase($book_id) {
        $cam_booking = CamBooking::model()->findByPk($book_id);
        if (!empty($cam_booking)) {
            $purchase = Purchase::model()->findByAttributes(array('book_id' => $book_id, 'user_id' => $cam_booking->book_user_id));
            if (empty($purchase)) {
                $model = new Purchase;
                $model->attributes = array(
                    'order_id' => Myclass::getPurchaseID(),
                    'book_id' => $book_id,
                    'user_id' => $cam_booking->book_user_id
                );
                $model->save(false);

                //Learner Purchase Complete Mail
                $mail = new Sendmail;
                $trans_array = array(
                    "{SITENAME}" => SITENAME,
                    "{ORDER_ID}" => $model->order_id,
                    "{USERNAME}" => $cam_booking->bookUser->username,
                    "{CAM}" => $cam_booking->cam->cam_title,
                    "{PURCHASE_DATE}" => date('Y-m-d', strtotime($cam_booking->book_date)),
                );
                $message = $mail->getMessage('cam_purchase_confirmation', $trans_array);
                $Subject = $mail->translate("{SITENAME}: Your Cam Purchase Confirmation");
                $attachment = '';
                if ($cam_booking->book_is_extra == 'Y') {
                    $attachment = UPLOAD_DIR . '/users/' . $cam_booking->cam->tutor_id . $cam_booking->cam->camExtras->extra_file;
                }
                $mail->send($cam_booking->bookUser->email, $Subject, $message, '', '', $attachment);
            }
        }
    }

}
