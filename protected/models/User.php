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
 * @property string $slug
 * @property string $is_auto_timezone
 * @property integer $user_locale_id
 * @property integer $user_timezone_id
 * @property integer $user_rating
 * @property integer $country_id
 * @property integer $receive_email_notify
 * 
 * The followings are the available model relations:
 * @property UserProfile $userProfGig[] $gigs
 * @property GigBooking[] $gigBookings
 * @property GigComments[] $gigComments
 * @property Timezone $userTimezone
 * @property Locales $userLocales
 * @property UserProfile $userProf
 * @property Message[] $user1Messages
 * @property Message[] $user2Messages
 * @property Gig[] $gigs
 * @property Purchase $gigPurchase
 * @property UserPaypal[] $userPaypals
 * @property Country $userCountry
 * @property SecurityQuestion $security_question
 */
class User extends RActiveRecord {

    public function init() {
        if ($this->isNewRecord) {
            $this->user_timezone_id = DEFAULT_TIMEZONE;
            $this->user_locale_id = DEFAULT_LOCALE;
            $this->country_id = DEFAULT_COUNTRY;
        }
        parent::init();
    }

    const GIG_PER_USER = 20;

    public function getFullname() {
        if ($this->userProf->prof_firstname == '' && $this->userProf->prof_lastname == '') {
            $fullname = $this->username;
        } else {
            $fullname = $this->userProf->prof_firstname . ' ' . $this->userProf->prof_lastname;
        }
        return $fullname;
    }

    public $old_password;
    public $new_password;
    public $repeat_password;
    public $confirm_password;
    public $i_agree;

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
            'deactivated' => array('condition' => "$alias.status = '3'"),
            'all' => array('condition' => "$alias.status is not null"),
            'current' => array('condition' => "$alias.status IN ('1', '0')"),
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
            array(
                'username',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                'message' => 'Invalid characters in username.(Spaces not Allowed)',
            ),
            array('username, email, password_hash', 'required', 'on' => 'insert'),
            array('username, email, password_hash', 'required', 'on' => 'admin_add'),
            array('username, email', 'required', 'on' => 'admin_edit'),
            array('email, confirm_password', 'required', 'on' => 'account_setting'),
            array('confirm_password', 'authenticate', 'on' => 'account_setting'),
            array('username, password_hash, password_reset_token, email', 'length', 'max' => 255),
            array('status, live_status', 'length', 'max' => 1),
            array('email, username, slug', 'unique'),
            array('email', 'email'),
            array('confirm_password', 'compare', 'compareAttribute' => 'password_hash', 'on' => 'register'),
            array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
            array('old_password', 'findPasswords', 'on' => 'changePwd'),
            array('repeat_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'),
            array('security_question_id, answer', 'required', 'on' => 'account_setting_security'),
            array('created_at, modified_at, user_activation_key, user_login_ip, user_last_login, is_auto_timezone, user_locale_id, user_timezone_id, i_agree, user_rating, country_id, old_password, new_password, repeat_password, security_question_id, answer, receive_email_notify', 'safe'),
            array('i_agree', 'compare', 'compareValue' => true, 'message' => 'You must agree to the terms and conditions', 'on' => 'register'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, username, password_hash, password_reset_token, email, status, live_status, created_at, modified_at, user_locale_id, user_timezone_id', 'safe', 'on' => 'search'),
        );
    }

    public function authenticate($attribute, $params) {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $is_correct_password = ($user->password_hash !== Myclass::encrypt($this->confirm_password)) ? false : true;
        if (!$is_correct_password)
            $this->addError('confirm_password', Myclass::t('Incorrect Password. Please enter your correct password.'));
    }

    //matching the old password with your existing password.
    public function findPasswords($attribute, $params) {
        $user = User::model()->findByPk(Yii::app()->user->id);
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
            'userProf' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
            'user1Messages' => array(self::HAS_MANY, 'Message', 'user1'),
            'user2Messages' => array(self::HAS_MANY, 'Message', 'user2'),
            'locales' => array(self::BELONGS_TO, 'Locales', 'user_locale_id'),
            'userTimezone' => array(self::BELONGS_TO, 'Timezone', 'user_timezone_id'),
            'gigs' => array(self::HAS_MANY, 'Gig', 'tutor_id'),
            'gigBookings' => array(self::HAS_MANY, 'GigBooking', 'book_user_id'),
            'gigComments' => array(self::HAS_MANY, 'GigComments', 'user_id'),
            'gigPurchase' => array(self::HAS_MANY, 'Purchase', 'user_id'),
            'userPaypals' => array(self::HAS_MANY, 'UserPaypal', 'user_id'),
            'userCountry' => array(self::BELONGS_TO, 'Country', 'country_id'),
            'security_question' => array(self::BELONGS_TO, 'SecurityQuestion', 'security_question_id'),
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
            'receive_email_notify' => 'Receive notification to email',
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

        $criteria->order = 'created_at desc';

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

        $ip_info = Myclass::getTimezone();
        if (!empty($ip_info)) {
            $model->country_id = Country::getCountryByName(strtoupper($ip_info['country']));
        }
        if ($model->is_auto_timezone == 'Y') {
            if (!empty($ip_info)) {
                $model->user_timezone_id = Timezone::getTimezoneByName($ip_info['timezone']);
            }
        }

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
        if ($return_type == 'array') {
            return $langArr;
        }
        $languages = Language::model()->findAllByAttributes(array('lang_Id' => $langArr));
        foreach ($languages as $key => $language) {
            $lang .= $language->lang_name . ', ';
        }
        return rtrim($lang, ', ');
    }

    public function getCountry() {
        $Country = Country::model()->findByPk($this->userProf->country_id);
        return $Country->country_name;
    }

    public function getProfileimage($htmlOptions = array()) {
        if (!empty($this->userProf->prof_picture))
            $path = UPLOAD_DIR . '/users/' . $this->user_id . $this->userProf->prof_picture;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/profile-img.jpeg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }

    public function getProfilethumb($htmlOptions = array('class' => 'img-circle')) {
        if (!empty($this->userProf->prof_picture))
            $path = UPLOAD_DIR . '/users/' . $this->user_id . '/thumb' . $this->userProf->prof_picture;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/profile-pic.jpeg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }

    public function getGigcount() {
        return Gig::model()->mine()->exceptDelete()->count();
    }

    public function getPurchasecount() {
        return count($this->gigPurchase);
    }

    public static function switchStatus($user_id, $live_status) {
        $user = User::model()->findByAttributes(array('user_id' => $user_id));
        $user->saveAttributes(array('live_status' => $live_status));
    }

    public function getStatusbutton() {
        switch ($this->live_status) {
            case 'A':
                $btn_class = 'online-btn';
                $btn_title = 'Online';
                $btn_mode = 'A';
                break;
            case 'B':
                $btn_class = 'online-btn busy-btn';
                $btn_title = 'Busy';
                $btn_mode = 'B';
                break;
            case 'O':
                $btn_class = 'offline-btn';
                $btn_title = 'Offline';
                $btn_mode = 'O';
                break;
        }
        return CHtml::link('<i class="fa fa-power-off"></i>', 'javascript:void(0)', array('class' => "{$btn_class}", 'data-toggle' => "tooltip", 'data-placement' => "bottom", 'title' => "{$btn_title}", 'id' => 'switch_status', 'data-mode' => $btn_mode));
    }

}
