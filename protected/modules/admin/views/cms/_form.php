<?php
/* @var $this CmsController */
/* @var $model Cms */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'cms-form',
                'htmlOptions' => array('role' => 'form', 'class' => ''),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'cms_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'cms_title'); ?>
                <?php echo $form->error($model, 'cms_title'); ?>
            </div>
            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'cms_tag', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'cms_tag'); ?>
                <?php echo $form->error($model, 'cms_tag'); ?>
            </div>
            <div class = "form-group form-control-material static" style="height: 350px">
                <?php echo $form->labelEx($model, 'cms_description'); ?><br />
                <?php // echo $form->textArea($model, 'cms_description', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php
                $this->widget('application.extensions.cleditor.ECLEditor', array(
                    'model' => $model,
                    'attribute' => 'cms_description', //Model attribute name. Nome do atributo do modelo.
                    'options' => array(
                        'width' => 1190,
                        'height' => 300,
                        'useCSS' => true,
                    ),
                    'value' => $model->cms_description, //If you want pass a value for the widget. I think you will. Se você precisar passar um valor para o gadget. Eu acho irá.
                ));
                ?>
                <?php echo $form->error($model, 'cms_description'); ?>
            </div>
            <div class = "form-group form-control-material static textarea-div">
                <?php echo $form->textArea($model, 'cms_meta_keywords', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'cms_meta_keywords'); ?>
                <?php echo $form->error($model, 'cms_meta_keywords'); ?>
            </div>
            <div class = "form-group form-control-material static  textarea-div">
                <?php echo $form->textArea($model, 'cms_meta_description', array('class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'cms_meta_description'); ?>
                <?php echo $form->error($model, 'cms_meta_description'); ?>
            </div>
            <div class = "form-group checkbox checkbox-primary">
                <?php echo $form->checkBox($model, 'status', array('class' => 'form-control')); ?>
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