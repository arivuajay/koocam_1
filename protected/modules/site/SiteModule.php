<?php

class SiteModule extends CWebModule {
    
    public $homeUrl = array('/site/default/index');
    public $layout = '//layouts/column1';

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'site.components.*',
        ));
        Yii::app()->theme = 'koocam'; 
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');

        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => '/site/default/error'),
            'user' => array(
                'class' => 'CWebUser',
                'allowAutoLogin' => true,
            )
        ));

        Yii::app()->user->setStateKeyPrefix('_site');
        Yii::app()->user->loginUrl = Yii::app()->createUrl("/{$this->id}/default/index");
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }
}
