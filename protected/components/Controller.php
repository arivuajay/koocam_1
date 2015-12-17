<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    protected $homeUrl = '';
    protected $homeAbsoluteUrl = '';

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $flashMessages = array();
    public $themeUrl = '';
    public $title = '';
    public $rightCornerLink = '';

    public function init() {
        parent::init();
        $this->homeUrl = Yii::app()->controller->module->homeUrl;
        $this->layout = Yii::app()->controller->module->layout;
        $this->homeAbsoluteUrl = Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->homeUrl[0]);

        CHtml::$errorSummaryCss = 'alert alert-danger';
        CHtml::$errorMessageCss = 'text-danger';

        $this->flashMessages = Yii::app()->user->getFlashes();
        $this->themeUrl = Yii::app()->theme->baseUrl;

        if (Yii::app()->user->hasState('userLocale')) {
            Yii::app()->localtime->Locale = Yii::app()->user->userLocale;
        }

        if (Yii::app()->user->hasState('userTimezone')) {
            Yii::app()->localtime->TimeZone = Yii::app()->user->userTimezone;
        }
        
        if(Yii::app()->controller->module->id == 'site' 
                && !Yii::app()->user->isGuest && !Yii::app()->request->isAjaxRequest 
                && Yii::app()->urlManager->parseUrl(Yii::app()->request) != 'site/default/cron'
                ){
            TempSession::insertSession(Yii::app()->user->id);
        }
    }

    public function goHome() {
        $this->redirect($this->homeUrl);
    }

    public function deniedCallback() {
        Yii::app()->user->setFlash('danger', "You must Login to Access !!!");
        if(!Yii::app()->request->isAjaxRequest)
            Yii::app()->session['refer_url'] = Yii::app()->request->hostInfo . Yii::app()->request->url;
        $this->goHome();
    }

}
