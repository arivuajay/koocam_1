<?php
/* @var $this TransactionController */
/* @var $model Transaction */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'transaction-form',
                'htmlOptions' => array('role' => 'form', 'class' => ''),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>

            <?php echo $form->errorSummary(); ?>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'user_id', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'user_id'); ?>
                <?php echo $form->error($model, 'user_id'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'trans_type', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
                <?php echo $form->labelEx($model, 'trans_type'); ?>
                <?php echo $form->error($model, 'trans_type'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'book_id', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'book_id'); ?>
                <?php echo $form->error($model, 'book_id'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'trans_admin_amount', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->labelEx($model, 'trans_admin_amount'); ?>
                <?php echo $form->error($model, 'trans_admin_amount'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'trans_user_amount', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->labelEx($model, 'trans_user_amount'); ?>
                <?php echo $form->error($model, 'trans_user_amount'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'transaction_id', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'transaction_id'); ?>
                <?php echo $form->error($model, 'transaction_id'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textArea($model, 'trans_message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'trans_message'); ?>
                <?php echo $form->error($model, 'trans_message'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'paypal_address', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                <?php echo $form->labelEx($model, 'paypal_address'); ?>
                <?php echo $form->error($model, 'paypal_address'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'created_at', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'created_at'); ?>
                <?php echo $form->error($model, 'created_at'); ?>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>