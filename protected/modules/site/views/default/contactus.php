<?php
/* @var $this GigController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->title = 'Contact us';
$themeUrl = $this->themeUrl;

$categories = array(
    "Technical Support" => "Technical Support",
    "Payment related Enquiry" => "Payment related Enquiry",
    "Gig related Enquiry" => "Gig related Enquiry"
);
?>
<div id="inner-banner" class="tt-fullHeight3">
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
                        'id' => 'gig-contactus-form',
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    <?php echo $form->errorSummary($model); ?>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo $form->textField($model, 'fullname', array('class' => 'form-control', 'placeholder' => 'Fullname', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Fullname")); ?> 
                            <?php echo $form->error($model, 'fullname'); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Email', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Email")); ?> 
                            <?php echo $form->error($model, 'email'); ?> 
                        </div>
                    </div>

                    <?php if(!Yii::app()->user->isGuest){ ?>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <?php echo $form->dropDownList($model, 'category', $categories, array('class' => 'selectpicker', 'prompt' => 'Choose Category', 'data-title' => "Choose Category")); ?> 
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
                            <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'placeholder' => 'Message', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Message")); ?> 
                            <?php echo $form->error($model, 'message'); ?> 
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