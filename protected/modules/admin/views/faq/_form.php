<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'faq-form',
                'htmlOptions' => array('role' => 'form', 'class' => ''),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>

            <?php echo $form->errorSummary($model); ?>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'question', array('class' => 'form-control', 'size' => 60, 'maxlength' => 500)); ?>
                <?php echo $form->labelEx($model, 'question'); ?>
                <?php echo $form->error($model, 'question'); ?>
            </div>
            <div class = "form-group form-control-material static textarea-div">
                <?php echo $form->textArea($model, 'answer', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'answer'); ?>
                <?php echo $form->error($model, 'answer'); ?>
            </div>


            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>