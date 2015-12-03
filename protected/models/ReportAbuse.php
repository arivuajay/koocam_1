<?php

/**
 * This is the model class for table "{{report_abuse}}".
 *
 * The followings are the available columns in table '{{report_abuse}}':
 * @property integer $abuse_id
 * @property integer $book_id
 * @property string $abuse_message
 * @property string $created_at
 * @property string $modified_at
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
            array('book_id, abuse_message', 'required'),
            array('book_id', 'numerical', 'integerOnly' => true),
            array('abuse_message, modified_at', 'safe'),
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
            'abuse_message' => 'Abuse Message',
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
            $learner = $this->book->bookUser;
            $tutor = $this->book->gig->tutor;
            $gig = $this->book->gig;
            
            $mail = new Sendmail;
            $trans_array = array(
                "{SITENAME}" => SITENAME,
                "{LEARNER}" => $learner->fullname,
                "{EMAIL_ID}" => $learner->email,
                "{TUTOR}" => $tutor->fullname,
                "{TUTOR_EMAIL}" => $tutor->email,
                "{GIG}" => $gig->gig_title,
                "{ABUSE_MESSAGE}" => $this->abuse_message,
            );
            $message = $mail->getMessage('report_abuse', $trans_array);
            $Subject = $mail->translate("Report Abuse For GIG ({$gig->gig_title})");
            $mail->send(Admin::ADMIN_EMAIL, $Subject, $message);
        }
        return parent::afterSave();
    }

}
