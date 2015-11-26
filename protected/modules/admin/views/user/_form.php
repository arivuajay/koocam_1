<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'htmlOptions' => array('role' => 'form', 'class' => ''),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage'=>true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            
            <?php echo $form->errorSummary(array($model,$userProfile)); ?>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'username'); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
            
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'password_hash', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'password_hash'); ?>
                <?php echo $form->error($model, 'password_hash'); ?>
            </div>
            
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            
            <div class = "form-group checkbox checkbox-primary">
                <?php echo $form->checkBox($model, 'status', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
            
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($userProfile, 'prof_firstname', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($userProfile, 'prof_firstname'); ?>
                <?php echo $form->error($userProfile, 'prof_firstname'); ?>
            </div>
            
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($userProfile, 'prof_lastname', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($userProfile, 'prof_lastname'); ?>
                <?php echo $form->error($userProfile, 'prof_lastname'); ?>
            </div>
            
            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>