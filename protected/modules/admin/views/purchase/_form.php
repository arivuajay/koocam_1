<?php
/* @var $this PurchaseController */
/* @var $model Purchase */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchase-form',
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
                        <?php echo $form->textField($model,'user_id',array('class'=>'form-control')); ?>
                        <?php echo $form->labelEx($model,'user_id'); ?>
                        <?php echo $form->error($model,'user_id'); ?>
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