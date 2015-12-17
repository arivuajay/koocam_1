<?php
/* @var $this ContactusController */
/* @var $model Contactus */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contactus-form',
        'htmlOptions' => array('role' => 'form', 'class' => ''),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'hideErrorMessage' => true,
        ),
	'enableAjaxValidation'=>true,
)); ?>

            <?php echo $form->errorSummary($model); ?>
            
                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'contact_name',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->labelEx($model,'contact_name'); ?>
                        <?php echo $form->error($model,'contact_name'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'contact_email',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->labelEx($model,'contact_email'); ?>
                        <?php echo $form->error($model,'contact_email'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textArea($model,'contact_message',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
                        <?php echo $form->labelEx($model,'contact_message'); ?>
                        <?php echo $form->error($model,'contact_message'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'user_id',array('class'=>'form-control')); ?>
                        <?php echo $form->labelEx($model,'user_id'); ?>
                        <?php echo $form->error($model,'user_id'); ?>
                    </div>
                                                <div class = "form-group form-control-material static">
                        <?php echo $form->textField($model,'contact_category',array('class'=>'form-control','size'=>2,'maxlength'=>2)); ?>
                        <?php echo $form->labelEx($model,'contact_category'); ?>
                        <?php echo $form->error($model,'contact_category'); ?>
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