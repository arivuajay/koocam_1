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
        $user = User::model()->find('username = :U OR email = :U', array(':U' => $this->username));
        
        if ($user === null):
            $this->errorCode = self::ERROR_USERNAME_INVALID;

        elseif ($user->status == 0):
            $this->errorCode = self::ERROR_ACCOUNT_BLOCKED;
        else:
            $is_correct_password = ($user->password_hash !== Myclass::encrypt($this->password)) ? false : true;

            if ($is_correct_password):
                $this->errorCode = self::ERROR_NONE;
            else:
                $this->errorCode = self::ERROR_USERNAME_INVALID;   // Error Code : 1
            endif;
        endif;

        if ($this->errorCode == self::ERROR_NONE):
            $this->setUserData($user);
        endif;

        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

    public function autoLogin() {
        $user = User::model()->find('username = :U', array(':U' => $this->username));
        if ($user === null):
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else:
            $this->setUserData($user);
        endif;
        return !$this->errorCode;
    }

    protected function setUserData($user) {
        $this->_id = $user->user_id;
        $this->setState('name', $user->username);
        $this->setState('id', $user->user_id);
        $this->setState('slug', $user->slug);
        return;
    }
}
