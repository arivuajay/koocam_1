<?php

/**
 * Site controller
 */
class CamController extends Controller {

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
                'actions' => array('view', 'search'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'upload', 'update', 'changepricepertime', 'mycams', 'userdelete', 'sendmessage'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'actions' => array(),
                'users' => array('*'),
                'deniedCallback' => array($this, 'deniedCallback'),
            ),
        );
    }

    /**
     * 
     */
    public function actionCreate() {
        $totCams = Cam::userCamsCount(Yii::app()->user->id, 'exceptDelete');
        if ($totCams >= User::CAM_PER_USER) {
            Yii::app()->user->setFlash('danger', "You reached your maximum Cam limit. Maximum Cams : " . User::CAM_PER_USER);
            $this->goHome();
        }

        $model = new Cam('create');
        $this->performAjaxValidationWithOutFileField($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Cam')) {
            $model->attributes = Yii::app()->request->getPost('Cam');
            $model->tutor_id = Yii::app()->user->id;
            $model->setAttribute('cam_media', isset($_FILES['Cam']['name']['cam_media']) ? $_FILES['Cam']['name']['cam_media'] : '');

            if ($model->validate()) {
                if ($model->is_video == 'N') {
                    $model->setUploadDirectory(UPLOAD_DIR . '/users/' . Yii::app()->user->id);
                    $model->uploadFile();
                }
                if ($model->save()) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = new CamExtra;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'cam_id' => $model->cam_id,
                        );
                        $extra_model->setAttribute('extra_file', isset($_FILES['Cam']['name']['extra_file']) ? $_FILES['Cam']['name']['extra_file'] : '');
                        if ($extra_model->validate()) {
                            $extra_model->save(false);
                        }
                    }
                    Yii::app()->user->setFlash('success', "Cam created. Sent for Approval.");
                    $this->redirect(array("/site/cam/success", "slug" => $model->slug));
                }
            }
        }
        $this->render('create', compact('model'));
    }
    
    public function actionSuccess($slug){
        $model = Cam::model()->inactive()->findByAttributes(array('slug' => $slug));
        if(!empty($model)){
            $this->render('success', compact('model'));
        }
        $this->goHome();
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';

        if ($model->tutor_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Cam')) {
            $model->attributes = Yii::app()->request->getPost('Cam');
            $model->tutor_id = Yii::app()->user->id;
            $model->setAttribute('cam_media', isset($_FILES['Cam']['name']['cam_media']) ? $_FILES['Cam']['name']['cam_media'] : '');

            if ($model->validate()) {
                if ($model->cam_media) {
                    if ($model->is_video == 'N') {
                        $model->setUploadDirectory(UPLOAD_DIR . '/users/' . Yii::app()->user->id);
                        $model->uploadFile();
                    }
                } else {
                    unset($model->cam_media);
                }
                if ($model->save()) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = empty($model->camExtras) ? new CamExtra : $model->camExtras;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'cam_id' => $model->cam_id,
                        );
                        if (isset($_FILES['Cam']['name']['extra_file']) && !empty($_FILES['Cam']['name']['extra_file'])) {
                            $extra_model->setAttribute('extra_file', $_FILES['Cam']['name']['extra_file']);
                        }
                        if ($extra_model->validate()) {
                            $extra_model->save(false);
                        }
                    }
                    Yii::app()->user->setFlash('success', "Cam updated successfully");
                    $this->redirect(array('/site/cam/view', 'slug' => $model->slug));
                }
            }
        }
        $this->render('update', compact('model'));
    }

    /**
     * 
     */
    public function actionView($slug) {
        $model = $this->loadModelSlug($slug);
        $booking_model = new CamBooking();
        $booking_temp = new BookingTemp();
        $cam_comments = new CamComments();
        $message = new Message;
        $this->performAjaxValidation($booking_model);
        $this->render('view', compact('model', 'booking_model', 'booking_temp', 'cam_comments', 'message'));
    }

    public function actionUserdelete($id) {
        $model = $this->loadModel($id);

        if ($model->tutor_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $valid = $model->saveAttributes(array('status' => '2'));
        if ($valid):
            Yii::app()->user->setFlash('success', "Cam Deleted successfully");
        else:
            Yii::app()->user->setFlash('danger', "Failed to delete. Try again later..");
        endif;
        $this->redirect(array('/site/cam/mycams'));
    }

    public function actionSendmessage() {
        $message = new Message;
        $this->performAjaxValidation($message);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Message')) {
            $message->attributes = Yii::app()->request->getPost('Message');
            $model = $this->loadModel($message->cam_id);

            Message::insertMessage($message->message, Yii::app()->user->id, $model->tutor_id, $model->cam_id);

            Yii::app()->user->setFlash('success', "Message sent successfully!!!");
            $this->redirect(array('/site/cam/view', 'slug' => $model->slug));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Cam::model()->findByPk($id);
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

    protected function performAjaxValidationWithOutFileField($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model, Cam::ajaxValidationFields());
            Yii::app()->end();
        }
    }

    public function loadModelSlug($slug) {
        $model = Cam::model()->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionChangepricepertime() {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Cam')) {
            $post = Yii::app()->request->getPost('Cam');
            $limits = Myclass::priceLimitation();
            $prev_timestamp = key(array(current($limits)));
            if ($post['cam_duration'] == '')
                $post['cam_duration'] = 0;
            $given_timestamp = strtotime(date('H:i', mktime(0, $post['cam_duration'])));
            $given_price = $err_price = $post['cam_price'];

            $i = 1;
            $iMax = count($limits);

//          Old Codings
//            foreach ($limits as $calc_timestamp => $calc_price) {
//                if ($given_price < $calc_price) {
//                    if (($given_timestamp > $prev_timestamp && $given_timestamp <= $calc_timestamp)) {
//                        $err_price = $calc_price;
//                    } else if ($given_timestamp > $calc_timestamp && $i == $iMax) {
//                        $err_price = $calc_price;
//                    }
//                }
//                $prev_timestamp = $calc_timestamp;
//                $i++;
//            }
            foreach ($limits as $calc_timestamp => $calc_price) {
                if ($given_timestamp >= $calc_timestamp) {
                    if ($given_price < $calc_price) {
                        $error = true;
                        $err_price = $calc_price;
                    }
                }
                $prev_timestamp = $calc_timestamp;
                $i++;
            }
            echo $err_price;
        }
        Yii::app()->end();
    }

    public function actionSearch() {
        $sort_by = $page_size = $category_id = '';
        $cat_ids = array();
        $search_text = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

        $model = new Cam('search');
        $this->performAjaxValidation($model);
        $alias = $model->getTableAlias(false, false);

        $criteria = new CDbCriteria;
        $criteria->with = array('tutor');

        $criteria->compare($alias . '.cam_title', $search_text, true);

        if (isset($_REQUEST['cat_id'])) {
            $cat_ids = $_REQUEST['cat_id'];
            $criteria->addInCondition('cat_id', $cat_ids);
        }

        if (isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != 0) {
            $category_id = $_REQUEST['category_id'];
            $criteria->compare($alias . '.cat_id', $category_id);
        }

        if (isset($_REQUEST['sort_by']) && !empty($_REQUEST['sort_by'])) {
            $criteria->order = $sort_by = $_REQUEST['sort_by'];
        } else {
            $criteria->order = 'tutor.live_status ASC';
        }

        //Pagination
        if (isset($_REQUEST['page_size']) && !empty($_REQUEST['page_size'])) {
            $page_size = $_REQUEST['page_size'];
        } else {
            $page_size = Cam::CAM_SEARCH_LIMIT;
        }
        $pages = new CPagination(Cam::model()->active()->count($criteria));
        $pages->pageSize = $page_size;
        $pages->applyLimit($criteria);

        $results = Cam::model()->active()->findAll($criteria);

        if (Yii::app()->request->isAjaxRequest) {
            $result = $this->renderPartial('_search_results', compact('results', 'pages'), true);
            if ($_REQUEST['custom_search'] == 1) {
                $return = array('item_count' => "({$pages->itemCount} Results Found)", 'result' => $result);
                echo json_encode($return);
            } else {
                echo $result;
            }
            Yii::app()->end();
        } else {
            $this->render('search', compact('model', 'results', 'search_text', 'pages', 'sort_by', 'page_size', 'cat_ids', 'category_id'));
        }
    }

    public function actionMycams() {
        $this->layout = '//layouts/user_dashboard';

        $model = new Cam();
        $criteria = new CDbCriteria;
        $alias = $model->getTableAlias(false, false);
        $criteria->order = 'created_at DESC';

        $pages = new CPagination(Cam::model()->mine()->exceptDelete()->count($criteria));
        $pages->pageSize = Cam::MY_CAM_LIMIT;
        $pages->applyLimit($criteria);
        $results = Cam::model()->mine()->exceptDelete()->findAll($criteria);

        $this->render('mycams', compact('results'));
    }

}
