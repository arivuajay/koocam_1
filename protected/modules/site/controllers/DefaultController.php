<?php

/**
 * Site controller
 */
class DefaultController extends Controller {

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actions() {
        return array(
            'download' => 'application.components.actions.download',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'sociallogin', 'signupsocial', 'login', 'register', 'activation', 'chat'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'test'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm;
        $this->performAjaxValidation($model);

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()):
                Yii::app()->user->setFlash('success', "You logged in successfully!!!");
                $this->goHome();
            endif;
        }
    }

    public function actionRegister() {
        if (!Yii::app()->user->isGuest)
            $this->goHome();

        $model = new User('register');
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $valid = $model->validate();
            if ($valid) {
                $model->addUser();
                Yii::app()->user->setFlash('success', "Please check your mail for activation");
                $this->goHome();
            }
        }
    }

    public function actionLogout() {
        Yii::app()->user->logout(false);
        Yii::app()->user->setFlash('success', "You were logged out successfully");
        $this->goHome();
    }

    public function actionActivation($activationkey, $userid) {
        $user = User::model()->findByAttributes(array(
            'user_id' => $userid,
            'user_activation_key' => $activationkey,
            'user_last_login' => '0000-00-00 00:00:00'
                )
        );
        if (empty($user))
            throw new CHttpException(404, 'The specified post cannot be found.');

        $user = User::model()->findByPk($userid);
        $user->setAttribute('status', '1');
        $user->setAttribute('user_last_login', date('Y-m-d H:i:s'));
        if ($user->save(false)) {
            ///////////////////////////
            if (!empty($user->email)):
                $mail = new Sendmail;
                $loginlink = $this->homeAbsoluteUrl;
                $trans_array = array(
                    "{SITENAME}" => SITENAME,
                    "{USERNAME}" => $user->username,
                    "{EMAIL_ID}" => $user->email,
                    "{NEXTSTEPURL}" => $loginlink,
                );
                $message = $mail->getMessage('activation', $trans_array);
                $Subject = $mail->translate('{SITENAME}: Email Verified');
                $mail->send($user->email, $Subject, $message);
            endif;
            /////////////////////////

            Yii::app()->user->setFlash('success', "Your Email account verified. you can login");
            $this->goHome();
        } else {
            echo var_dump($user->getErrors());
        }
        exit;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSociallogin() {
        Yii::import('application.components.HybridAuthIdentity');
        $path = Yii::getPathOfAlias('ext.HybridAuth');
        require_once $path . '/hybridauth-' . HybridAuthIdentity::VERSION . '/hybridauth/index.php';
    }

    public function actionSignupsocial($provider) {
        try {

            Yii::import('application.components.HybridAuthIdentity');
            $haComp = new HybridAuthIdentity();
            if (!$haComp->validateProviderName($provider))
                throw new CHttpException('500', 'Invalid Action. Please try again.');

            $haComp->adapter = $haComp->hybridAuth->authenticate($provider);
            $haComp->userProfile = $haComp->adapter->getUserProfile();
            $haComp->processLogin();  //further action based on successful login or re-direct user to the required url
            $redirectUrl = $this->homeAbsoluteUrl;
            echo "<script type='text/javascript'>if(window.opener){window.opener.location = '$redirectUrl';window.close();}else{window.opener.location = '$redirectUrl';}</script>";
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
            //process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
            $this->redirect(array('/site/users/register'));
            return;
        }

        Yii::app()->end(true);
    }

    public function actionTest() {
        echo 'hi';
        exit;
        $mail = new Sendmail;
        $loginlink = $this->homeAbsoluteUrl;
        $trans_array = array(
            "{SITENAME}" => SITENAME,
            "{USERNAME}" => '$user->username',
            "{EMAIL_ID}" => '$user->email',
            "{NEXTSTEPURL}" => '$loginlink',
        );
        $message = $mail->getMessage('activation', $trans_array);
        $Subject = $mail->translate('{SITENAME}: Email Verified');
        echo '<pre>';
        var_dump($mail->send('prakash.paramanandam@arkinfotec.com', $Subject, $message));
        exit;
        exit;
    }

    public function actionChat() {
        $this->render('chat');
    }
}
