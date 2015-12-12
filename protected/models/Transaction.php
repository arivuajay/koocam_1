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
 * @property string $trans_reply
 * @property string $paypal_address
 * @property string $created_at
 * @property string $modified_at
 * @property string $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Transaction extends RActiveRecord {

    public $is_message;
    public $new_paypal;

    const TYPE_REVENUE = "R";
    const TYPE_EXPENSE = "E";
    const TYPE_WITHDRAW = "W";
    const MIN_WITHDRAW_AMT = 10;

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
            array('paypal_address, new_paypal', 'email'),
            array('paypal_address', 'required', 'on' => 'withdraw'),
            array('transaction_id', 'required', 'on' => 'approve'),
            array('trans_reply', 'required', 'on' => 'reject'),
            array('trans_user_amount', 'numerical', 'min' => self::MIN_WITHDRAW_AMT, 'max' => Transaction::myCurrentBalance(), 'on' => 'withdraw'),
            array('user_id, book_id', 'numerical', 'integerOnly' => true),
            array('trans_type', 'length', 'max' => 1),
            array('trans_admin_amount, trans_user_amount', 'length', 'max' => 10),
            array('transaction_id', 'length', 'max' => 255),
            array('paypal_address', 'length', 'max' => 100),
            array('trans_message, created_at, modified_at, is_message, trans_reply, status, new_paypal', 'safe'),
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
            'booking' => array(self::BELONGS_TO, 'GigBooking', 'book_id'),
        );
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $user_id = Yii::app()->user->id;
        $type_expense = self::TYPE_EXPENSE;

        return array(
            'myPayments' => array('condition' => "$alias.user_id = $user_id AND $alias.trans_type != '$type_expense'"),
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
            'trans_admin_amount' => 'Commission Amount',
            'trans_user_amount' => 'Amount',
            'transaction_id' => 'Transaction Id',
            'trans_message' => 'Message',
            'trans_reply' => 'Reply',
            'paypal_address' => 'Paypal Address',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'status' => 'Status',
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
        $criteria->compare('trans_reply', $this->trans_reply, true);
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

            //Learner Purchase Complete Mail
            $mail = new Sendmail;
            $trans_array = array(
                "{SITENAME}" => SITENAME,
                "{USERNAME}" => $gig_booking->bookUser->username,
                "{GIG}" => $gig_booking->gig->gig_title,
                "{PURCHASE_DATE}" => date('Y-m-d', strtotime($gig_booking->book_date)),
            );
            $message = $mail->getMessage('gig_purchase_confirmation', $trans_array);
            $Subject = $mail->translate("{SITENAME}: Your Gig Purchase Confirmation");
            $attachment = '';
            if ($gig_booking->book_is_extra == 'Y') {
                $attachment = UPLOAD_DIR . '/users/' . $gig_booking->gig->tutor_id . $gig_booking->gig->gigExtras->extra_file;
            }
            $mail->send($gig_booking->bookUser->email, $Subject, $message, '', '', $attachment);

            //Tutor Transaction - Revenue
            //Tutor Revenue only the user gig price / extra price, Not include the user procession / service fees.
            $book_total_price_tutor = $gig_booking->beforetaxamount;
            $calculation_price = self::adminCommissionCalculation($book_total_price_tutor);
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

    public static function myTotalExpense() {
        $user_id = Yii::app()->user->id;
        $type_expense = self::TYPE_EXPENSE;
        $total_expense = Yii::app()->db->createCommand()
                ->select('SUM(`trans_user_amount`) as total_expense')
                ->from('{{transaction}}')
                ->andWhere('user_id = ' . $user_id . ' AND trans_type = "' . $type_expense . '"')
                ->queryRow();
        return ($total_expense['total_expense']) ? $total_expense['total_expense'] : "0";
    }

    public static function myTotalRevenue() {
        $user_id = Yii::app()->user->id;
        $type_revenue = self::TYPE_REVENUE;
        $total_revenue = Yii::app()->db->createCommand()
                ->select('SUM(`trans_user_amount`) as total_revenue')
                ->from('{{transaction}}')
                ->andWhere('user_id = ' . $user_id . ' AND trans_type = "' . $type_revenue . '"')
                ->queryRow();
        return ($total_revenue['total_revenue']) ? $total_revenue['total_revenue'] : "0.00";
    }

    public static function myTotalWithdraw() {
        $user_id = Yii::app()->user->id;
        $type_withdraw = self::TYPE_WITHDRAW;
        $total_withdraw = Yii::app()->db->createCommand()
                ->select('SUM(`trans_user_amount`) as total_withdraw')
                ->from('{{transaction}}')
                ->andWhere('user_id = ' . $user_id . ' AND trans_type = "' . $type_withdraw . '" AND status != "2"')
                ->queryRow();
        return ($total_withdraw['total_withdraw']) ? $total_withdraw['total_withdraw'] : "0.00";
    }

    public static function myCurrentBalance() {
        $balance = 0;
        $total_revenue = self::myTotalRevenue();
        $total_withdraw = self::myTotalWithdraw();
        if ($total_revenue > 0) {
            $current_balance = $total_revenue - $total_withdraw;
            $balance = $current_balance > 0 ? number_format($current_balance, "2") : 0;
        }
        return $balance;
    }

    public function beforeValidate() {
        if ($this->is_message == 'Y') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'trans_message', array()));
        }
        if ($this->paypal_address == 'others@others.other') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'new_paypal', array()));
        }
        if ($this->status == '2') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'trans_reply', array()));
        }

        return parent::beforeValidate();
    }

    protected function beforeSave() {
        if ($this->paypal_address == 'others@others.other' && $this->new_paypal != '')
            $this->paypal_address = $this->new_paypal;

        return parent::beforeSave();
    }

    protected function afterSave() {
        if ($this->new_paypal != '') {
            $exists = UserPaypal::model()->mine()->findAll('paypal_address = :paypal', array(':paypal' => $this->paypal_address));
            if (empty($exists)) {
                $user_paypal = new UserPaypal;
                $user_paypal->attributes = array(
                    'user_id' => $this->user_id,
                    'paypal_address' => $this->paypal_address
                );
                $user_paypal->save(false);
            }
        }
        return parent::afterSave();
    }

    public function cashwithdrawMail() {
        //To admin
        $mail = new Sendmail;

        $user_email = $this->user->email;
        $username = $this->user->fullname;
        $amt = $this->trans_user_amount;
        $paypal = $this->paypal_address;

        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $username,
            "{EMAIL_ID}" => $user_email,
            "{AMOUNT}" => $amt,
            "{PAYPAL}" => $paypal,
            "{REQUEST_MESSAGE}" => $this->trans_message,
        );
        $message = $mail->getMessage('cash_withdraw_notification', $trans_array);
        $Subject = $mail->translate("Cashwithdraw Request From {$username}");
        $mail->send(ADMIN_EMAIL, $Subject, $message);

        //To User
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $username,
            "{AMOUNT}" => $amt,
            "{PAYPAL}" => $paypal,
        );
        $message = $mail->getMessage('cash_withdraw_request', $trans_array);
        $Subject = $mail->translate(SITENAME . ": Cashwithdraw Request Sent");
        $mail->send($user_email, $Subject, $message);
    }

    public function cashApprove() {
        $mail = new Sendmail;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $this->user->fullname,
            "{AMOUNT}" => $this->trans_user_amount,
            "{PAYPAL}" => $this->paypal_address,
            "{TRANSACTION_ID}" => $this->transaction_id,
            "{REPLY_MESSAGE}" => $this->trans_reply,
        );
        $message = $mail->getMessage('cash_withdraw_approve', $trans_array);
        $Subject = $mail->translate(SITENAME . ": Cashwithdraw Amount Sent");
        $mail->send($this->user->email, $Subject, $message);

        $notifn_message = "Your Cash withdraw request for {$this->trans_user_amount}$ sent successfully to your account {$this->paypal_address}";
        Notification::insertNotification($this->user->user_id, $notifn_message);
    }

    public function cashReject() {
        $mail = new Sendmail;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => $this->user->fullname,
            "{AMOUNT}" => $this->trans_user_amount,
            "{REPLY_MESSAGE}" => $this->trans_reply,
        );
        $message = $mail->getMessage('cash_withdraw_reject', $trans_array);
        $Subject = $mail->translate(SITENAME . ": Cashwithdraw Request Canceled");
        $mail->send($this->user->email, $Subject, $message);

        Notification::insertNotification($this->user->user_id, "Your Cash withdraw request for {$this->trans_user_amount}$ canceled");
    }
    
    public function getMylastpaypal() {
        $user_id = Yii::app()->user->id;
        return self::model()->find('user_id = :user_id And trans_type = :type Order by created_at DESC' , array(':user_id' => $user_id, ':type' => 'W'))->paypal_address;
    }

}
