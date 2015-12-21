<?php

/**
 * Site controller
 */
class CmsController extends Controller {

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
                'actions' => array(''),
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
    public function actionView($slug) {
        $model = $this->loadModelSlug($slug);
        $themeUrl = $this->themeUrl;
        $params = array(
            "{STEP1}" => CHtml::image("{$themeUrl}/images/step1.png", ''),
            "{STEP2}" => CHtml::image("{$themeUrl}/images/step2.png", ''),
            "{STEP3}" => CHtml::image("{$themeUrl}/images/step3.png", ''),
            "{STEP4}" => CHtml::image("{$themeUrl}/images/step4.png", ''),
            "{STEP5}" => CHtml::image("{$themeUrl}/images/step5.png", ''),
            "{STEP6}" => CHtml::image("{$themeUrl}/images/step6.png", ''),
            "{VIDEO}" => '<iframe width="100%" height="315" src="https://www.youtube.com/embed/it9WajjCmro" frameborder="0" allowfullscreen></iframe>',
        );
        $content = strtr($model->cms_description, $params);
        $this->render('view', compact('model', 'content'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthorAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Cms::model()->findByPk($id);
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

    public function loadModelSlug($slug) {
        $model = Cms::model()->findByAttributes(array('slug' => $slug));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
