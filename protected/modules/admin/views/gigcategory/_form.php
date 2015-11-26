<?php
/* @var $this GigCategoryController */
/* @var $model GigCategory */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'gig-category-form',
                'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => "multipart/form-data"),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <?php echo $form->errorSummary($model); ?>

            <div class="form-group form-control-material static">
                <?php echo $form->textField($model, 'cat_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100, 'placeholder' => 'Category Name')); ?>
                <?php echo $form->labelEx($model, 'cat_name'); ?>
                <?php echo $form->error($model, 'cat_name'); ?>
            </div>

            <div class="form-group form-control-material static">
                <?php echo $form->textArea($model, 'cat_description', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'cat_description'); ?>
                <?php echo $form->error($model, 'cat_description'); ?>
            </div>

            <div class="form-group form-control-material static">
                <?php echo $form->fileField($model, 'cat_image'); ?>
                <?php // echo $form->labelEx($model, 'cat_image'); ?>
                <?php echo $form->error($model, 'cat_image'); ?>
            </div>

            <div class="form-group checkbox checkbox-primary">
                <?php echo $form->checkBox($model, 'status'); ?>  
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>