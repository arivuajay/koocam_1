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
                'actions' => array('view', 'search'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'upload', 'update', 'changepricepertime', 'mygigs', 'userdelete'),
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
        $this->performAjaxValidationWithOutFileField($model);
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
                            $extra_model->save(false);
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
                if ($model->gig_media) {
                    $model->setUploadDirectory(UPLOAD_DIR . '/users/' . Yii::app()->user->id);
                    $model->uploadFile();
                } else {
                    unset($model->gig_media);
                }
                if ($model->save()) {
                    if ($model->is_extra == 'Y') {
                        $extra_model = empty($model->gigExtras) ? new GigExtra : $model->gigExtras;
                        $extra_model->attributes = array(
                            'extra_price' => $model->extra_price,
                            'extra_description' => $model->extra_description,
                            'gig_id' => $model->gig_id,
                        );
                        if (isset($_FILES['Gig']['name']['extra_file']) && !empty($_FILES['Gig']['name']['extra_file'])) {
                            $extra_model->setAttribute('extra_file', $_FILES['Gig']['name']['extra_file']);
                        }
                        if ($extra_model->validate()) {
                            $extra_model->save(false);
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
        $booking_model = new GigBooking();
        $booking_temp = new BookingTemp();
        $gig_comments = new GigComments();
        $this->performAjaxValidation($booking_model);
        $this->render('view', compact('model', 'booking_model', 'booking_temp', 'gig_comments'));
    }

    public function actionUserdelete($id) {
        $model = $this->loadModel($id);

        if ($model->tutor_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', "Invalid Access !!!");
            $this->goHome();
        }
        $valid = $model->saveAttributes(array('status' => '2'));
        if ($valid):
            Yii::app()->user->setFlash('success', "Gig Deleted successfully");
        else:
            Yii::app()->user->setFlash('danger', "Failed to delete. Try again later..");
        endif;
        $this->redirect(array('/site/gig/mygigs'));
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
            echo CActiveForm::validate($model, Gig::ajaxValidationFields());
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
        $model = new Gig('search');
        $this->performAjaxValidation($model);

        $search_text = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

        $criteria = new CDbCriteria;
        $alias = $model->getTableAlias(false, false);

        $sort_by = $page_size = '';
        $cat_ids = array();

        if (isset($_REQUEST['sort_by'])) {
            $criteria->order = $sort_by = $_REQUEST['sort_by'];
        }
        if (isset($_REQUEST['cat_id'])) {
            $cat_ids = $_REQUEST['cat_id'];
            $criteria->addInCondition('cat_id', $cat_ids);
        }
        if (isset($_REQUEST['page_size'])) {
            $page_size = $_REQUEST['page_size'];
        } else {
            $page_size = Gig::GIG_SEARCH_LIMIT;
        }

        $criteria->compare($alias . '.gig_title', $search_text, true);

        $pages = new CPagination(Gig::model()->count($criteria));
        $pages->pageSize = $page_size;
        $pages->applyLimit($criteria);

        $results = Gig::model()->findAll($criteria);

        if (Yii::app()->request->isAjaxRequest) {
            $result = $this->renderPartial('_search_results', compact('results', 'pages'), true);
            $return = array('item_count' => "({$pages->itemCount} Results Found)", 'result' => $result);
            echo json_encode($return);
            Yii::app()->end();
        } else {
            $this->render('search', compact('model', 'results', 'search_text', 'pages', 'sort_by', 'page_size', 'cat_ids'));
        }
    }

    public function actionMygigs() {
        $this->layout = '//layouts/user_dashboard';

        $model = new Gig();
        $criteria = new CDbCriteria;
        $alias = $model->getTableAlias(false, false);
        $criteria->order = 'created_at DESC';

        $pages = new CPagination(Gig::model()->mine()->exceptDelete()->count($criteria));
        $pages->pageSize = Gig::MY_GIG_LIMIT;
        $pages->applyLimit($criteria);
        $results = Gig::model()->mine()->exceptDelete()->findAll($criteria);

        $this->render('mygigs', compact('results'));
    }

}
