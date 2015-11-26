<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $user_id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $status
 * @property string $user_activation_key
 * @property string $user_login_ip
 * @property string $user_last_login
 * @property string $live_status
 * @property string $created_at
 * @property string $modified_at
 * @property string $slug
 * 
 * The followings are the available model relations:
 * @property UserProfile $userProf
 */
class User extends RActiveRecord {

    const GIG_PER_USER = 20;

    public function getFullname() {
        return $this->userProf->prof_firstname . ' ' . $this->userProf->prof_lastname;
    }

    public $confirm_password;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    public function behaviors() {
        return array(
            'SlugBehavior' => array(
                'class' => 'application.models.behaviors.SlugBehavior',
                'slug_col' => 'slug',
                'title_col' => 'username',
                'overwrite' => true
            )
        );
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        return array(
            'active' => array('condition' => "$alias.status = '1'"),
            'inactive' => array('condition' => "$alias.status = '0'"),
            'deleted' => array('condition' => "$alias.status = '2'"),
            'all' => array('condition' => "$alias.status is not null"),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password_hash, email, confirm_password', 'required', 'on' => 'register'),
            array('username, email, password_hash', 'required', 'on' => 'insert'),
            array('username, email, password_hash', 'required', 'on' => 'admin_add'),
            array('username, email', 'required', 'on' => 'admin_edit'),
            array('username, password_hash, password_reset_token, email', 'length', 'max' => 255),
            array('status, live_status', 'length', 'max' => 1),
            array('email, username', 'unique'),
            array('email', 'email'),
            array('password_hash', 'compare', 'compareAttribute' => 'confirm_password', 'on' => 'register'),
            array('created_at, modified_at, user_activation_key, user_login_ip, user_last_login', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, username, password_hash, password_reset_token, email, status, live_status, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userProf' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'username' => 'Username',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'live_status' => 'A -> Available, B -> Busy, O -> Offline',
            'created_at' => 'Created At',
            'modified_at' => 'Updated At',
            'confirm_password' => 'Confirm Password',
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
        $alias = $this->getTableAlias(false, false);

        $criteria->compare($alias . '.user_id', $this->user_id);
        $criteria->compare($alias . '.username', $this->username, true);
        $criteria->compare($alias . '.password_hash', $this->password_hash, true);
        $criteria->compare($alias . '.password_reset_token', $this->password_reset_token, true);
        $criteria->compare($alias . '.email', $this->email, true);
        $criteria->compare($alias . '.status', $this->status, true);
        $criteria->compare($alias . '.live_status', $this->live_status, true);
        $criteria->compare($alias . '.created_at', $this->created_at, true);
        $criteria->compare($alias . '.modified_at', $this->modified_at, true);

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
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        return new CActiveDataProvider($this, array(
//            'pagination' => array(
//                'pageSize' => PAGE_SIZE,
//            )
        ));
    }

    public function beforeSave() {
        if ($this->isNewRecord):
            $this->user_login_ip = Yii::app()->request->getUserHostAddress();
            $this->user_activation_key = Myclass::getRandomString();
            $this->password_hash = Myclass::encrypt($this->password_hash);
        endif;

        return parent::beforeSave();
    }

    public function addUser() {
        $model = new User('insert');
        $model->username = $this->username;
        $model->email = $this->email;
        $model->password_hash = $this->password_hash;
        $model->status = '0';
        $model->save(false);
        ///////////////////////
        $confirmationlink = SITEURL . '/site/default/activation?activationkey=' . $model->user_activation_key . '&userid=' . $model->user_id;
        if (!empty($model->email)):
            //$loginlink = Yii::app()->createAbsoluteUrl('/site/default/login');
            $mail = new Sendmail;
            $trans_array = array(
                "{SITENAME}" => SITENAME,
                "{USERNAME}" => $model->username,
                "{EMAIL_ID}" => $model->email,
                "{NEXTSTEPURL}" => $confirmationlink,
            );
            $message = $mail->getMessage('registration', $trans_array);
            $Subject = $mail->translate('Confirmation Mail From {SITENAME}');
            $mail->send($model->email, $Subject, $message);
        endif;
        ///////////////////
        return;
    }

    public static function getUsersList($status = 'all') {
        return CHtml::listData(self::model()->$status()->findAll(), 'user_id', 'username');
    }

    public function getLanguages($return_type = 'string') {
        $lang = '';
        $langArr = CJSON::decode($this->userProf->prof_languages);
        if($return_type == 'array'){
            return $langArr;
        }
        $languages = Language::model()->findAllByAttributes(array('lang_Id' => $langArr));
        foreach ($languages as $key => $language) {
            $lang .= $language->lang_name . ', ';
        }
        return rtrim($lang, ', ');
    }
    
    public function getCountry(){
        $Country = Country::model()->findByPk($this->userProf->country_id);
        return $Country->country_name;
    }

}
