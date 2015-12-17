<?php
/* @var $this CamController */
/* @var $model Contactus */
/* @var $form CActiveForm */

$this->title = 'Contact us';
$themeUrl = $this->themeUrl;

$categories = $model->getCategoryList();
?>
<div id="inner-banner" class="tt-fullHeight3 contactus-banner">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Contact Us </h2>
                <p> Get In Touch </p>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 ">
                <div class="forms-cont account-settingform">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> Send Message </div>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'cam-contactus-form',
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => false,
                    ));
                    ?>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 ">
                            <?php echo $form->errorSummary($model); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo $form->textField($model, 'contact_name', array('class' => 'form-control', 'placeholder' => 'Fullname', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Fullname")); ?> 
                            <?php echo $form->error($model, 'contact_name'); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo $form->textField($model, 'contact_email', array('class' => 'form-control', 'placeholder' => 'Email', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Email")); ?> 
                            <?php echo $form->error($model, 'contact_email'); ?> 
                        </div>
                    </div>

                    <?php if (!Yii::app()->user->isGuest) { ?>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <?php echo $form->hiddenField($model, 'user_id', array('value' => Yii::app()->user->id)); ?> 
                                <?php echo $form->dropDownList($model, 'contact_category', $categories, array('class' => 'selectpicker', 'prompt' => 'Choose Category', 'data-title' => "Choose Category")); ?> 
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
                            <?php echo $form->textArea($model, 'contact_message', array('class' => 'form-control', 'placeholder' => 'Message', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Message")); ?> 
                            <?php echo $form->error($model, 'contact_message'); ?> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 "> 
                            <?php $this->widget('CCaptcha', array('captchaAction'=>'/site/default/captcha')); ?>
                            <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control', 'placeholder' => 'Captcha')); ?>
                            <?php echo $form->error($model, 'verifyCode'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo CHtml::submitButton('Send Message', array('class' => 'btn btn-default  btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>