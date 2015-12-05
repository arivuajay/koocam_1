<?php

/**
 * This is the model class for table "{{transaction}}".
 *
 * The followings are the available columns in table '{{transaction}}':
 * @property integer $trans_id
 * @property integer $user_id
 * @property string $trans_type
 * @property integer $book_id
 * @property string $trans_admin_amount
 * @property string $trans_user_amount
 * @property string $transaction_id
 * @property string $trans_message
 * @property string $paypal_address
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Transaction extends RActiveRecord {

    const TYPE_REVENUE = "R";
    const TYPE_EXPENSE = "E";
    const TYPE_WITHDRAW = "W";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, trans_user_amount', 'required'),
            array('user_id, book_id', 'numerical', 'integerOnly' => true),
            array('trans_type', 'length', 'max' => 1),
            array('trans_admin_amount, trans_user_amount', 'length', 'max' => 10),
            array('transaction_id', 'length', 'max' => 255),
            array('paypal_address', 'length', 'max' => 100),
            array('trans_message, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('trans_id, user_id, trans_type, book_id, trans_admin_amount, trans_user_amount, transaction_id, trans_message, paypal_address, created_at, modified_at', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'trans_id' => 'Trans',
            'user_id' => 'User',
            'trans_type' => 'Trans Type',
            'book_id' => 'Book',
            'trans_admin_amount' => 'Trans Admin Amount',
            'trans_user_amount' => 'Trans User Amount',
            'transaction_id' => 'Transaction',
            'trans_message' => 'Trans Message',
            'paypal_address' => 'Paypal Address',
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

        $criteria->compare('trans_id', $this->trans_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('trans_type', $this->trans_type, true);
        $criteria->compare('book_id', $this->book_id);
        $criteria->compare('trans_admin_amount', $this->trans_admin_amount, true);
        $criteria->compare('trans_user_amount', $this->trans_user_amount, true);
        $criteria->compare('transaction_id', $this->transaction_id, true);
        $criteria->compare('trans_message', $this->trans_message, true);
        $criteria->compare('paypal_address', $this->paypal_address, true);
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
     * @return Transaction the static model class
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

    //booking Transaction for both Tutor and Learner
    public static function bookingTransaction($book_id) {
        $gig_booking = GigBooking::model()->findByPk($book_id);

        if (!empty($gig_booking)) {
            //Learner Transaction - Expense
            $learner_transaction = new Transaction;
            $learner_transaction->user_id = $gig_booking->book_user_id;
            $learner_transaction->trans_type = self::TYPE_EXPENSE;
            $learner_transaction->book_id = $book_id;
            $learner_transaction->trans_admin_amount = 0;
            $learner_transaction->trans_user_amount = $gig_booking->book_total_price;
            $learner_transaction->save(false);

            //Tutor Transaction - Revenue
            $calculation_price = self::adminCommissionCalculation($gig_booking->book_total_price);
            $tutor_transaction = new Transaction;
            $tutor_transaction->user_id = $gig_booking->gig->tutor_id;
            $tutor_transaction->trans_type = self::TYPE_REVENUE;
            $tutor_transaction->book_id = $book_id;
            $tutor_transaction->trans_admin_amount = $calculation_price['admin_amount'];
            $tutor_transaction->trans_user_amount = $calculation_price['user_amount'];
            $tutor_transaction->save(false);
        }
    }

    public static function adminCommissionCalculation($amount) {
        $commission_percent = COMMISSION_PERCENT;
        $admin_amount = $amount * ($commission_percent / 100);
        $user_amount = $amount - $admin_amount;
        $return = array();
        $return['admin_amount'] = $admin_amount;
        $return['user_amount'] = $user_amount;
        return $return;
    }

}
