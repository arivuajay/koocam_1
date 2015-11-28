<?php

/**
 * Message controller
 */
class MessageController extends Controller {

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'readmessage'),
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
        $sql = Message::getMyMsgListQuery();
        $total_items = Yii::app()->db->createCommand($sql)->queryAll();
        $item_count = count($total_items);

        $dataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount' => $item_count,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            ),
        ));

        $model = $dataProvider->getData();

        $this->render('index', compact('dataProvider', 'model'));
    }

    public function actionReadmessage($conversation_id) {
        $model = new Message;
        $session_userid = Yii::app()->user->id;
        $mymessages = array();

        $this->performAjaxValidation(array($model));

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['Message'];
            $valid = $model->validate();
            if ($valid) {

                $model->id1 = $conversation_id; // conversation id
                $model->user1 = $session_userid; // Sender
                $model->timestamp = time();
                $model->user1read = "Y";
                $model->user2read = "N";

                $model->save(false);

                Yii::app()->user->setFlash('success', "Message send successfully!!!");
                $this->redirect(array('index'));
            }
        }

        if (isset($conversation_id)) {
            $id1 = intval($conversation_id);
            $msginfo = Message::model()->findByAttributes(array('id1' => $id1, 'id2' => "1"));
            $msgcount = count($msginfo);
            //We check if the discussion exists
            if ($msgcount == 1) {
                $u1 = $msginfo['user1'];
                $u2 = $msginfo['user2'];

                if ($u1 == $session_userid || $u2 == $session_userid) {

                    // Update the unread messages to read
                    $sql = "UPDATE {{message}} SET user2read = 'Y' WHERE  user2 = '$session_userid' and id1= '$id1'";
                    $command = Yii::app()->db->createCommand($sql)->execute();

                    $mymessages = Yii::app()->db->createCommand() //this query contains all the data
                            ->select('message.timestamp, message.message, user.user_id, user.username')
                            ->from(array('{{message}} message', '{{user}} user'))
                            ->where("message.id1 = '$id1' and user.user_id = message.user1")
                            ->order('message.id2')
                            ->queryAll();
                } else {
                    Yii::app()->user->setFlash('danger', 'You dont have the rights to access this page.!');
                    $this->redirect(array('index'));
                }
            } else {
                Yii::app()->user->setFlash('danger', 'This discussion does not exists!');
                $this->redirect(array('index'));
            }
        } else {
            Yii::app()->user->setFlash('danger', 'This discussion does not exists!');
            $this->redirect(array('index'));
        }

        $this->render('readmessage', compact('model', 'mymessages', 'u1', 'u2'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * 
     * @param type $model
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
