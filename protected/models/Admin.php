<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $admin_id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Admin extends CActiveRecord {

    public $old_password;
    public $new_password;
    public $repeat_password;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{admin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password_hash, email, created_at', 'required'),
            array('username, password_hash, password_reset_token, email', 'length', 'max' => 255),
            array('status', 'length', 'max' => 1),
            array('updated_at', 'safe'),
            array('email', 'email'),
            array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
            array('old_password', 'findPasswords', 'on' => 'changePwd'),
            array('repeat_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('admin_id, username, password_hash, password_reset_token, email, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    //matching the old password with your existing password.
    public function findPasswords($attribute, $params) {
        $user = Admin::model()->findByPk(Yii::app()->user->id);
        if ($user->password_hash != Myclass::encrypt($this->old_password))
            $this->addError($attribute, 'Old password is incorrect.');
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'admin_id' => 'Admin',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password_hash', $this->password_hash, true);
        $criteria->compare('password_reset_token', $this->password_reset_token, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

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
     * @return Admin the static model class
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
