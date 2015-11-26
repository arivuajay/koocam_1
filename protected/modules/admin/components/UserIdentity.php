<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    const ERROR_ACCOUNT_BLOCKED = 3;
    const ERROR_ACCOUNT_DELETED = 4;

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $admin = Admin::model()->find('username = :U', array(':U' => $this->username));

        if ($admin === null):
            $this->errorCode = self::ERROR_USERNAME_INVALID;

        elseif ($admin->status == 0):
            $this->errorCode = self::ERROR_ACCOUNT_BLOCKED;
        else:
            $is_correct_password = ($admin->password_hash !== Myclass::encrypt($this->password)) ? false : true;

            if ($is_correct_password):
                $this->errorCode = self::ERROR_NONE;
            else:
                $this->errorCode = self::ERROR_USERNAME_INVALID;   // Error Code : 1
            endif;
        endif;

        if ($this->errorCode == self::ERROR_NONE):
            $this->setUserData($admin);
        endif;

        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

    public function autoLogin() {
        $admin = User::model()->find('username = :U', array(':U' => $this->username));
        if ($admin === null):
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else:
            $this->setUserData($admin);
        endif;
        return !$this->errorCode;
    }

    protected function setUserData($admin) {
        $this->_id = $admin->admin_id;
        $this->setState('name', $admin->username);
        $this->setState('id', $admin->admin_id);
        return;
    }
}
