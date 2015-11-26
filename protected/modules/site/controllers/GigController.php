<?php

/**
 * Site controller
 */
class GigController extends Controller {

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
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'upload', 'update', 'changepricepertime'),
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
        $totGigs = Gig::userGigsCount(Yii::app()->user->id);
        if ($totGigs >= User::GIG_PER_USER) {
            Yii::app()->user->setFlash('danger', "You reached your maximum Gig limit. Maximum Gigs : " . User::GIG_PER_USER);
            $this->goHome();
        }

        $model = new Gig('create');
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Gig')) {
            $model->attributes = Yii::app()->request->getPost('Gig');
            $model->tutor_id = Yii::app()->user->id;
            $model->setAttribute('gig_media', isset($_FILES['Gig']['name']['gig_media']) ? $_FILES['Gig']['name']['gig_media'] : '');

            if ($model->validate()) {
                $model->setUploadDirectory(UPLOAD_DIR . '/users/' . Yii::app()->user->id);
                $model->uploadFile();
                if ($model->save()) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = new GigExtra;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'gig_id' => $model->gig_id,
                        );
                        $extra_model->setAttribute('extra_file', isset($_FILES['Gig']['name']['extra_file']) ? $_FILES['Gig']['name']['extra_file'] : '');
                        if ($extra_model->validate()) {
                            /* temp solution */
                            if (!empty($_FILES['Gig']['name']['extra_file'])) {
                                $user_path = $upl_dir = UPLOAD_DIR . '/users/' . Yii::app()->user->id;
                                $extra_model->setUploadDirectory($user_path . '/gigextra');
                                $newName = trim(md5(time())) . '.' . CFileHelper::getExtension($_FILES['Gig']['name']['extra_file']);
                                $dir = DIRECTORY_SEPARATOR . strtolower(get_class($extra_model)) . DIRECTORY_SEPARATOR;
                                if (move_uploaded_file($_FILES['Gig']['tmp_name']['extra_file'], $upl_dir . $newName))
                                    $extra_model->extra_file = $dir . $newName;
//                            $extra_model->uploadFile();
                            }
                            /* end */
                            $extra_model->save();
                        }
                    }
                    Yii::app()->user->setFlash('success', "Gig created. Sent for Approval.");
                    $this->refresh();
                }
            }
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';

        if ($model->tutor_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Gig')) {
            $model->attributes = Yii::app()->request->getPost('Gig');
            $model->tutor_id = Yii::app()->user->id;
            $model->setAttribute('gig_media', isset($_FILES['Gig']['name']['gig_media']) ? $_FILES['Gig']['name']['gig_media'] : '');

            if ($model->validate()) {
                $model->setUploadDirectory(UPLOAD_DIR . '/users/' . Yii::app()->user->id);
                $model->uploadFile();
                if ($model->save()) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = new GigExtra;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'gig_id' => $model->gig_id,
                        );
                        $extra_model->setAttribute('extra_file', isset($_FILES['Gig']['name']['extra_file']) ? $_FILES['Gig']['name']['extra_file'] : '');
                        if ($extra_model->validate()) {
                            /* temp solution */
                            if (!empty($_FILES['Gig']['name']['extra_file'])) {
                                $user_path = $upl_dir = UPLOAD_DIR . '/users/' . Yii::app()->user->id;
                                $extra_model->setUploadDirectory($user_path . '/gigextra');
                                $newName = trim(md5(time())) . '.' . CFileHelper::getExtension($_FILES['Gig']['name']['extra_file']);
                                $dir = DIRECTORY_SEPARATOR . strtolower(get_class($extra_model)) . DIRECTORY_SEPARATOR;
                                if (move_uploaded_file($_FILES['Gig']['tmp_name']['extra_file'], $upl_dir . $newName))
                                    $extra_model->extra_file = $dir . $newName;
//                            $extra_model->uploadFile();
                            }
                            /* end */
                            $extra_model->save();
                        }
                    }
                    Yii::app()->user->setFlash('success', "Gig updated successfully");
                    $this->refresh();
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
        $this->render('view', compact('model'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Gig::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = 'upload/temp/'; // folder for uploaded files
        $allowedExtensions = array("jpg"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME

        echo $return; // it's array
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

    public function loadModelSlug($slug) {
        $model = Gig::model()->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionChangepricepertime() {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Gig')) {
            $post = Yii::app()->request->getPost('Gig');
            $limits = Myclass::priceLimitation();
            $prev_timestamp = key(array(current($limits)));
            if ($post['gig_duration'] == '')
                $post['gig_duration'] = 0;
            $given_timestamp = strtotime(date('H:i', mktime(0, $post['gig_duration'])));
            $given_price = $err_price = $post['gig_price'];

            $i = 1;
            $iMax = count($limits);

            foreach ($limits as $calc_timestamp => $calc_price) {
                if ($given_price < $calc_price) {
                    if (($given_timestamp > $prev_timestamp && $given_timestamp <= $calc_timestamp)) {
                        $err_price = $calc_price;
                    } else if ($given_timestamp > $calc_timestamp && $i == $iMax) {
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

}
