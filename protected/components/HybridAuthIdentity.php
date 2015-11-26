<?php

class HybridAuthIdentity extends CUserIdentity {

    const VERSION = '2.6.0';

    /**
     *
     * @var Hybrid_Auth
     */
    public $hybridAuth;

    /**
     *
     * @var Hybrid_Provider_Adapter
     */
    public $adapter;

    /**
     *
     * @var Hybrid_User_Profile
     */
    public $userProfile;
    public $allowedProviders = array('google', 'facebook', 'linkedin', 'yahoo', 'live', 'twitter');
    protected $config;

    function __construct() {
        $path = Yii::getPathOfAlias('ext.HybridAuth');
        require_once $path . '/hybridauth-' . self::VERSION . '/hybridauth/Hybrid/Auth.php';  //path to the Auth php file within HybridAuth folder

        $this->config = array(
            "base_url" => Yii::app()->createAbsoluteUrl("/site/default/sociallogin"),
            "providers" => array(
                "Google" => array(
                    "enabled" => true,
                    "keys" => array(
                        "id" => "288594682867-bb3csmegd3ka1b3o84anee98ugstd0db.apps.googleusercontent.com",
                        "secret" => "4LLWfiAIKSFsBLPr6AxsIFzl",
//                        "id" => GOOGLE_APP_ID,
//                        "secret" => GOOGLE_SECRET_ID
                    ),
                    "scope" => "https://www.googleapis.com/auth/userinfo.profile " . "https://www.googleapis.com/auth/userinfo.email",
                    "access_type" => "online",
                ),
                "Facebook" => array(
                    "enabled" => true,
                    "keys" => array(
                        "id" => "506092249568171",
                        "secret" => "9d672f389546c6957407b3a9d0b59038",
//                        "id" => FB_APP_ID,
//                        "secret" => FB_SECRET_ID
                    ),
                    "scope"   => "email, user_about_me, user_birthday, user_hometown", // optional
                    "display" => "popup"
                ),
                "Live" => array(
                    "enabled" => true,
                    "keys" => array(
                        "id" => "windows client id",
                        "secret" => "Windows Live secret",
                    ),
                    "scope" => "email"
                ),
                "Yahoo" => array(
                    "enabled" => true,
                    "keys" => array(
                        "key" => "yahoo client id",
                        "secret" => "yahoo secret",
                    ),
                ),
                "LinkedIn" => array(
                    "enabled" => true,
                    "keys" => array(
                        "key" => "75ceofjehdfs7j",
                        "secret" => "QfLa8xh0hnlvq81g",
                    ),
                ),
                "Twitter" => array(
                    "enabled" => true,
                    "keys" => array(
                        "key" => "xpee301A4Sohk0uvZjgyn30Kc",
                        "secret" => "aisllYXMlL2xI4y2VOs5nm5eXcJyXIdkjb1b4lSFyg59ptPbZu"
                    )
                )
            ),
            "debug_mode" => false,
            // to enable logging, set 'debug_mode' to true, then provide here a path of a writable file
            "debug_file" => "",
        );

        $this->hybridAuth = new Hybrid_Auth($this->config);
    }

    /**
     *
     * @param string $provider
     * @return bool
     */
    public function validateProviderName($provider) {
        if (!is_string($provider))
            return false;
        if (!in_array($provider, $this->allowedProviders))
            return false;

        return true;
    }

    public function processLogin() {        
        if (!empty($this->userProfile)) {
            $newrecord = false;
            $model = User::model()->find("email = '{$this->userProfile->email}'");

            if (is_null($model)):
                $newrecord = true;
                $model = new User();
            endif;

            $result = $this->registerNewUser($model, $newrecord);
            $identity = new UserIdentity($result->username, 'anonyms');
            $identity->autoLogin();
            Yii::app()->user->login($identity);

//            $model = new LoginForm('login');
//            $log = array('username' => $result->email, 'password' => $result->user_password);
//            $model->attributes = $log;
//            $model->login();
//            $identity->autoLogin();
//            Yii::app()->user->login($identity,0);
        }
    }

    public function registerNewUser($model, $newrecord) {
        if ($newrecord):
            $model->username = $this->userProfile->firstName;
            $model->email = $this->userProfile->email;
            $password = Myclass::getRandomString('8');
            $model->password_hash = Myclass::encrypt($password);
            $model->status = 1;
        else:
            $model->status = 1;
        endif;
        
        if ($model->validate()) {
            $model->save(false);
            if($newrecord){
                $user_profile = new UserProfile;
                $user_profile->user_id = $model->user_id;
                $user_profile->prof_firstname = $this->userProfile->firstName;
                $user_profile->prof_lastname = $this->userProfile->lastName;
                $user_profile->prof_address = $this->userProfile->address;
                $user_profile->prof_phone = $this->userProfile->phone;
                
                if ($user_profile->validate()) {
                    $user_profile->save(false);
                }
            }
            return $model;
        } else {
            echo CHtml::errorSummary($model);
            exit;
        }
        
//        if (!empty($this->userProfile->photoURL) && ($newrecord || empty($patient->profile_picture))):
//            if ($image = $patient->urlImageSave($this->userProfile->photoURL, rand()))
//                $model->user_avatar = $image;
//        endif;
//        
    }

}
