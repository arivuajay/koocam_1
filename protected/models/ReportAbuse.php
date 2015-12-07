<?php

/**
 * This is the model class for table "{{report_abuse}}".
 *
 * The followings are the available columns in table '{{report_abuse}}':
 * @property integer $abuse_id
 * @property integer $book_id
 * @property string $abuse_message
 * @property string $abuse_type
 * @property string $created_at
 * @property string $modified_at
 * @property string $abuser_role
 *
 * The followings are the available model relations:
 * @property GigBooking $book
 */
class ReportAbuse extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{report_abuse}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('book_id, abuse_type', 'required'),
            array('book_id', 'numerical', 'integerOnly' => true),
            array('abuse_message, modified_at, abuse_type, abuser_role', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('abuse_id, book_id, abuse_message, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'book' => array(self::BELONGS_TO, 'GigBooking', 'book_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'abuse_id' => 'Abuse',
            'book_id' => 'Book',
            'abuse_message' => 'Comments',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'abuse_type' => 'Type',
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

        $criteria->compare('abuse_id', $this->abuse_id);
        $criteria->compare('book_id', $this->book_id);
        $criteria->compare('abuse_message', $this->abuse_message, true);
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
     * @return ReportAbuse the static model class
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

    protected function afterSave() {
        if ($this->isNewRecord) {
            $mail = new Sendmail;
            
            $learner = $this->book->bookUser;
            $tutor = $this->book->gig->tutor;
            $gig = $this->book->gig;

            $abuse_types = CJSON::decode($this->abuse_type);
            $message = '<p style="color: #545454; font-size: 13px; line-height: 20px;">Report: ';
            foreach ($abuse_types as $key => $type) {
                $message .= self::getAbusetypename($type) . ', ';
            }
            $message = rtrim($message, ', ');
            $message .= '</p>';

            if (!empty($this->abuse_message)):
                $message .= '<p style="color: #545454; font-size: 13px; line-height: 20px;">';
                $message .= "Comments: {$this->abuse_message} </p>";
            endif;

            $tutor_name = $tutor->fullname;
            $tutor_email = $tutor->email;
            $learner_name = $learner->fullname;
            $learner_email = $learner->email;

            if ($this->abuser_role == 'learner') {
                $sender = $tutor_name;
                $sender_email = $tutor_email;
                $abuser_name = $learner_name;
                $abuser_email = $learner_email;
            } else if ($this->abuser_role == 'tutor') {
                $sender = $learner_name;
                $sender_email = $learner_email;
                $abuser_name = $tutor_name;
                $abuser_email = $tutor_email;
            }

            $trans_array = array(
                "{SITENAME}" => SITENAME,
                "{SENDER}" => $sender,
                "{EMAIL_ID}" => $sender_email,
                "{ABUSER}" => $abuser_name,
                "{ABUSER_EMAIL}" => $abuser_email,
                "{GIG}" => $gig->gig_title,
                "{ABUSE_MESSAGE}" => $message,
            );
            $message = $mail->getMessage('report_abuse', $trans_array);
            $Subject = $mail->translate("Report Abuse");
            $mail->send(ADMIN_EMAIL, $Subject, $message);
        }
        return parent::afterSave();
    }

    public static function getAbusetypeList() {
        return array(
            'F' => 'Offensive content',
            'D' => 'Did not display the Service',
            'O' => 'Other Comments',
        );
    }

    public static function getAbusetypename($type) {
        $types = self::getAbusetypeList();
        return $types[$type];
    }

    public function beforeValidate() {
        if (is_array($this->abuse_type) && in_array('O', $this->abuse_type)) {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'abuse_message', array()));
        }
        return parent::beforeValidate();
    }

    protected function beforeSave() {
        if (is_array($this->abuse_type)) {
            $this->abuse_type = CJSON::encode($this->abuse_type);
        }

        $is_tutor = $this->book->gig->tutor->user_id == Yii::app()->user->id;
        $is_learner = $this->book->bookUser->user_id == Yii::app()->user->id;

        if ($is_tutor) {
            $this->abuser_role = 'learner';
        } else if ($is_learner) {
            $this->abuser_role = 'tutor';
        }
        
        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->abuse_type = CJSON::decode($this->abuse_type);
        return parent::afterFind();
    }

}
