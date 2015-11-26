<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $email;
    public $username;
    public $password;
    public $rememberMe = 0;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            array('email', 'required', 'on' => 'forgotpass'),
            array('email', 'email'),
            //array('admin_username', 'email'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('admin', 'Username'),
            'password' => Yii::t('admin', 'Password'),
            'rememberMe' => Yii::t('admin', 'Remember me'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {

        if (!$this->hasErrors()):
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()):
                if ($this->_identity->errorCode)
                    $this->addError('password', Myclass::t('Incorrect User Name or Password. Please try again.'));
            endif;
        endif;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {

        if ($this->_identity === null):
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        endif;
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE):
            //$duration= 3600*24*30; // 30 days
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days

            if (Yii::app()->user->getStateKeyPrefix() == '_user') {
                $model = User::model()->findByPk($this->_identity->id);
                if (!empty($model)) {
                    $model->setAttribute('user_last_login', date('Y-m-d H:i:s'));
                    $model->setAttribute('user_login_ip', Yii::app()->request->getUserHostAddress());
                    $model->save(false);
                }
            }
            Yii::app()->user->login($this->_identity, $duration);
            MyClass::rememberMe($this->username, $this->rememberMe);
            return true;
        else:

        endif;
    }

}
