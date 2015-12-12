<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * user contact form data. It is used by the 'login' action of 'SiteController'.
 */
class ContactForm extends CFormModel {

    public $fullname;
    public $email;
    public $category;
    public $message;
    
    public function init() {
        if(!Yii::app()->user->isGuest){
            $user = User::model()->findByPk(Yii::app()->user->id);
            $this->email = $user->email;
            $this->fullname = $user->fullname;
        }
        parent::init();
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('fullname, email, message', 'required'),
            array('email', 'email'),
            array('category', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'fullname' => "Full name",
            'email' => "Email",
            'category' => "Category",
            'message' => "Message",
        );
    }

}
