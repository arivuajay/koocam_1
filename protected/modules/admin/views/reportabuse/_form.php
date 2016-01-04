<?php
/* @var $this ReportabuseController */
/* @var $model ReportAbuse */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'report-abuse-form',
        'htmlOptions' => array('role' => 'form', 'class' => ''),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'hideErrorMessage' => true,
        ),
	'enableAjaxValidation'=>true,
)); ?>

            <?php echo $form->errorSummary($model); ?>
            
                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'book_id',array('class'=>'form-control')); ?>
                        <?php echo $form->labelEx($model,'book_id'); ?>
                        <?php echo $form->error($model,'book_id'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'abuse_type',array('class'=>'form-control','size'=>30,'maxlength'=>30)); ?>
                        <?php echo $form->labelEx($model,'abuse_type'); ?>
                        <?php echo $form->error($model,'abuse_type'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textArea($model,'abuse_message',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
                        <?php echo $form->labelEx($model,'abuse_message'); ?>
                        <?php echo $form->error($model,'abuse_message'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'abuser_role',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->labelEx($model,'abuser_role'); ?>
                        <?php echo $form->error($model,'abuser_role'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'created_at',array('class'=>'form-control')); ?>
                        <?php echo $form->labelEx($model,'created_at'); ?>
                        <?php echo $form->error($model,'created_at'); ?>
                    </div>
                            
            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>