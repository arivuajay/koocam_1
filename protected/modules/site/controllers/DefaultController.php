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
                'actions' => array('index', 'sociallogin', 'signupsocial', 'login', 'register', 'activation', 'filecrypt', 'download', 'ajaxrun', 'ajaxrunuser'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'test', 'chat', 'reportabuse', 'upload', 'testtoken', 'filedownload', 'disconnect'),
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
        $model = new Gig('search');
        $this->performAjaxValidation($model);
        $this->render('index', compact('model'));
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
                User::switchStatus(Yii::app()->user->id, 'A');
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
        User::switchStatus(Yii::app()->user->id, 'O');
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

    public function actionChat($guid) {
        $info = GigTokens::getConnectInfo($guid);
        if (empty($info)) {
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $abuse_model = new ReportAbuse();
        $gig_comments = new GigComments();
        $token = $info['token'];

        if ($info['my_role'] == 'tutor' && $token->tutor_attendance == 0) {
            GigTokens::saveAttendance($token->token_id, 1, $token->learner_attendance);
        }
        if ($info['my_role'] == 'learner' && $token->learner_attendance == 0) {
            GigTokens::saveAttendance($token->token_id, $token->tutor_attendance, 1);
        }

        $this->render('chat', compact('token', 'abuse_model', 'info', 'gig_comments'));
    }

    public function actionReportabuse() {
        $model = new ReportAbuse();
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('ReportAbuse')) {
            $model->attributes = Yii::app()->request->getPost('ReportAbuse');
            if ($model->save()) {
                $token = $model->book->gigTokens;
                $token->saveAttributes(array('status' => '1'));
                User::switchStatus($model->book->book_user_id, 'A');
                User::switchStatus($model->book->gig->tutor_id, 'A');
            
                Yii::app()->user->setFlash('success', "Your Report sent to admin successfully & Your Chat closed !!!");
                $this->redirect(array('/site/purchase/mypurchase'));
//                $this->redirect(array('/site/default/chat', 'guid' => $model->book->book_guid));
            }
        }
    }

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $dir = UPLOAD_DIR . '/temp';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $folder = 'uploads/temp/'; // folder for uploaded files
//        $allowedExtensions = array("jpg"); //array("jpg","jpeg","gif","exe","mov" and etc...
//        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
//        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $uploader = new qqFileUploader();
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME

        echo $return; // it's array
    }

    public function actionFilecrypt() {
        if (isset($_POST['file']) && isset($_POST['guid'])) {
            $file_path = '/uploads/temp/' . $_POST['file'];
            $add_string = Myclass::getRandomString(7);
            $df = Myclass::refencryption($file_path) . $add_string;
            $text = $_POST['file'];
            echo CHtml::link($text, array('/site/default/filedownload', 'df' => $df, 'guid' => $_POST['guid']), array('target' => '_blank'));
        }
        Yii::app()->end();
    }

    public function actionTesttoken() {
        $role = GigTokens::TOKEN_ROLE;
        $expire = time() + (7 * 24 * 60 * 60);
        echo $session_key = Yii::app()->tok->createSession()->id;
        echo '<br />';
        echo $token_key = Yii::app()->tok->generateToken($session_key, $role, $expire);
        exit;
    }

    public function actionFiledownload($df, $guid) {
        $token = GigTokens::getAuthData($guid);
        if (empty($token)) {
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $df = substr($df, 0, -7);
        $file_path = Yii::app()->createAbsoluteUrl(Myclass::refdecryption($df));

        $content = @file_get_contents($file_path);
        if (!$content)
            throw new CHttpException(404, 'The requested page does not exist.');
        $filename = isset($_REQUEST["fn"]) ? $_REQUEST["fn"] : basename($file_path);
        Yii::app()->request->sendFile($filename, $content);
    }

    public function actionAjaxrun() {
        if (Yii::app()->request->isAjaxRequest) {
            $return['learner_waiting'] = 0;
            $return['update_notification_count'] = 0;
            $return['update_message_count'] = 0;
            $return['tutor_before_paypal_alert'] = 0;

            $themeUrl = $this->themeUrl;
            if (!Yii::app()->user->isGuest) {
                //Learner Waiting
                $bookings = $this->learnerWaiting();
                if (!empty($bookings)) {
                    $return['learner_waiting'] = 1;
                    $return['learner_name'] = $bookings->bookUser->fullname;
                    $return['learner_thumb'] = $bookings->bookUser->profilethumb;
                    $return['learner_link'] = CHtml::link('Start Chat', array('/site/default/chat', 'guid' => $bookings->book_guid), array('class' => "btn btn-default explorebtn"));
                }

                //Notification Count
                $notifn_count = $this->notificationCount();
                if ($notifn_count > 0 && $notifn_count != $_POST['old_notifn_count']) {
                    $return['update_notification_count'] = 1;
                    $return['notification_update'] = $this->renderPartial('//layouts/_notification_box', compact('themeUrl'), true, false);
                }

                //Message Count
                $msg_count = $this->messageCount();
                if ($msg_count > 0 && $msg_count != $_POST['old_msg_count']) {
                    $return['update_message_count'] = 1;
                    $return['message_update'] = $this->renderPartial('//layouts/_message_box', compact('themeUrl'), true, false);
                }

                //Tutor before paypal confirmation
                $tutorstartnowalert = $this->tutorBeforePaypalAlert();
                if (!empty($tutorstartnowalert)) {
                    $booking_data = unserialize($tutorstartnowalert->temp_value);
                    $return['tutor_before_paypal_alert'] = 1;
                    $user = User::model()->findByPk($tutorstartnowalert->user_id);
                    $gig = Gig::model()->findByPk($booking_data['temp_gig_id']);
                    $return['tutor_before_paypal_user_name'] = $user->username;
                    $return['tutor_before_paypal_user_thumb'] = $user->profilethumb;
                    $return['tutor_before_paypal_gig_name'] = $gig->gig_title;

                    $created_at = $tutorstartnowalert->created_at;
                    $created_at_time = strtotime($created_at);
                    $end_time = $created_at_time + (60 * 3); // 3 min greater from created
                    $end_time_format = date("Y/m/d H:i:s", $end_time);
                    $return['tutor_before_paypal_countdown'] = $end_time_format;

                    $return['tutor_before_paypal_approve'] = CHtml::link('<i class="fa fa-check-square-o"></i> Approve', array('/site/bookingtemp/approve', 'temp_guid' => $tutorstartnowalert->temp_guid), array('class' => "btn btn-default  explorebtn form-btn"));
                    $return['tutor_before_paypal_reject'] = CHtml::link('<i class="fa fa-remove"></i> Reject', array('/site/bookingtemp/reject', 'temp_guid' => $tutorstartnowalert->temp_guid), array('class' => "btn btn-default  explorebtn form-btn deactiveate-btn"));
                }
                echo CJSON::encode($return);
                Yii::app()->end();
            }
        }
    }

    protected function learnerWaiting() {
        $current_time = Yii::app()->localtime->getUTCNow('Y-m-d H:i:s');
        $user_id = Yii::app()->user->id;

        $alias = GigBooking::model()->getTableAlias(false, false);
        $condition = "$alias.book_start_time <= :currentTime AND $alias.book_end_time >= :currentTime";
        $condition .= " AND gig.tutor_id = :my_user_id";
        $condition .= " AND tutor.live_status = 'A'";
        $condition .= " AND gigTokens.tutor_attendance = '0'";

        return GigBooking::model()->with('gig', 'gigTokens', 'gig.tutor')->active()->completed()->find(array(
                    'condition' => $condition,
                    'params' => array(':currentTime' => $current_time, ':my_user_id' => $user_id)
        ));
    }

    protected function learnerEnded() {
        $current_time = Yii::app()->localtime->getUTCNow('Y-m-d H:i:s');
        $user_id = Yii::app()->user->id;

        $alias = GigBooking::model()->getTableAlias(false, false);
        $condition = "$alias.book_start_time <= :currentTime AND $alias.book_end_time >= :currentTime";
        $condition .= " AND $alias.book_user_id = :my_user_id";
        $condition .= " AND tutor.live_status = 'A'";
        $condition .= " AND gigTokens.tutor_attendance = '0'";

        return GigBooking::model()->with('gig', 'gigTokens', 'gig.tutor')->active()->completed()->find(array(
                    'condition' => $condition,
                    'params' => array(':currentTime' => $current_time, ':my_user_id' => $user_id)
        ));
    }

    protected function notificationCount() {
        $notifications = Notification::getNotificationsByUserId(Yii::app()->user->id);
        return count($notifications);
    }

    protected function messageCount() {
        $my_unread_msg_count = Message::getMyUnReadMsgCount();
        return $my_unread_msg_count;
    }

    protected function tutorBeforePaypalAlert() {
        $tutor_id = Yii::app()->user->id;
        $current_date = date("Y-m-d H:i:s");
        $temp_booking = BookingTemp::model()->find(array(
            "condition" => "tutor_id = :tutor_id AND status = :status AND created_at > :lasttime",
            "params" => array(":tutor_id" => $tutor_id, ":status" => "0", ":lasttime" => date("Y-m-d H:i:s", strtotime("-3 minutes", strtotime($current_date))))
        ));
        if (!empty($temp_booking)) {
            return $temp_booking;
        }
    }

    public function actionAjaxrunuser() {
        $return['user_waiting'] = 1;
        $user_id = Yii::app()->user->id;
        $guid = $_POST['temp_guid'];
        $temp_booking = BookingTemp::model()->find(array(
            "condition" => "user_id = :user_id AND temp_guid = :guid",
            "params" => array(":user_id" => $user_id, ":guid" => $guid)
        ));
        if (!empty($temp_booking)) {
            if ($temp_booking->status == "1") {
                $return["user_before_paypal_status"] = "success";
            } elseif ($temp_booking->status == "2") {
                $return["user_before_paypal_status"] = "rejected";
            }
        }
        echo CJSON::encode($return);
        Yii::app()->end();
    }

    public function actionDisconnect() {
        if(isset($_POST['token_id']) && Yii::app()->request->isAjaxRequest){
            $model = GigTokens::model()->findByPk($_POST['token_id']);
            $model->saveAttributes(array('status'=> '1'));
            
            User::switchStatus($model->book->book_user_id, 'A');
            User::switchStatus($model->book->gig->tutor_id, 'A');
        }
    }
}
