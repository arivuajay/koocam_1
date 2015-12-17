<?php

/**
 * This is the model class for table "{{contactus}}".
 *
 * The followings are the available columns in table '{{contactus}}':
 * @property integer $contact_id
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_message
 * @property string $contact_reply
 * @property integer $user_id
 * @property string $contact_category
 * @property string $created_at
 * @property string $modified_at
 * @property string $status
 * 
 * The followings are the available model relations:
 * @property User user $user
 */
class Contactus extends RActiveRecord {

    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{contactus}}';
    }

    public function getCategoryList() {
        return array(
            "TS" => "Technical Support",
            "PR" => "Payment related Enquiry",
            "CR" => "Cam related Enquiry"
        );
    }

    public function getCategory() {
        $categories = $this->getCategoryList();
        return $categories[$this->contact_category];
    }

    public function getCurrentstatuslist() {
        return array(
            0 => "In-Progress",
            1 => "Completed",
        );
    }

    public function getCurrentstatus() {
        $status = $this->getCurrentstatuslist();
        return $status[$this->status];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('contact_name, contact_email, contact_message', 'required', 'on' => 'user'),
            array('contact_reply', 'required', 'on' => 'admin'),
            array('contact_email', 'email'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('contact_name, contact_email', 'length', 'max' => 255),
            array('contact_category', 'length', 'max' => 2),
            array('created_at, modified_at, verifyCode, status, contact_reply', 'safe'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'user'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('contact_id, contact_name, contact_email, contact_message, user_id, contact_category, created_at, modified_at, verifyCode, status, contact_reply', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'contact_id' => 'Contact',
            'contact_name' => 'Name',
            'contact_email' => 'Email',
            'contact_message' => 'Message',
            'user_id' => 'User',
            'verifyCode' => 'Captcha',
            'contact_category' => 'Category',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'status' => 'Status',
            'contact_reply' => 'Reply',
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

        $criteria->compare('contact_id', $this->contact_id);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('contact_email', $this->contact_email, true);
        $criteria->compare('contact_message', $this->contact_message, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('contact_category', $this->contact_category, true);
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
     * @return Contactus the static model class
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

}
