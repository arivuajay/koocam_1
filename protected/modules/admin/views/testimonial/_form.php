<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'testimonial-form',
                'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => "multipart/form-data"),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage' => true,
                ),
                'enableAjaxValidation' => false,
            ));
            ?>

            <?php echo $form->errorSummary($model); ?>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'testimonial_user', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->labelEx($model, 'testimonial_user'); ?>
                <?php echo $form->error($model, 'testimonial_user'); ?>
            </div>
            <div class = "form-group form-control-material static textarea-div">
                <?php echo $form->textArea($model, 'testimonial_text', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'testimonial_text'); ?>
                <?php echo $form->error($model, 'testimonial_text'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->fileField($model, 'testimonial_image'); ?>
                <?php echo $form->error($model, 'testimonial_image'); ?>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>