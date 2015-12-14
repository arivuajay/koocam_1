<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$this->title = 'Reset Password';
$themeUrl = $this->themeUrl;
?>
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Reset Password </h2>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <?php
        /* @var $this GigController */
        /* @var $model Gig */
        /* @var $form CActiveForm */
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'reset-password-form',
            'htmlOptions' => array('role' => 'form', 'class' => ''),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'hideErrorMessage' => true,
            ),
            'enableAjaxValidation' => true,
        ));
        ?>            
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 ">
                <?php echo $form->errorSummary($model); ?>
                <div class="forms-cont">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> Reset your password </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <?php echo $form->labelEx($model, 'new_password'); ?>
                            <?php echo $form->passwordField($model, 'new_password', array('class' => 'form-control', 'placeholder' => 'New Password', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "New Password")); ?> 
                            <?php echo $form->error($model, 'new_password'); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <?php echo $form->labelEx($model, 'repeat_password'); ?>
                            <?php echo $form->passwordField($model, 'repeat_password', array('class' => 'form-control', 'placeholder' => 'Repeat Password', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Repeat Password")); ?> 
                            <?php echo $form->error($model, 'repeat_password'); ?> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <?php echo CHtml::submitButton('Reset Password', array('class' => 'btn btn-default  btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
