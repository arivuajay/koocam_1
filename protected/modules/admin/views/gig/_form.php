<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'gig-form',
                'htmlOptions' => array('role' => 'form', 'class' => ''),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>

            <?php echo $form->errorSummary($model); ?>

            <?php
            $tutors = User::getUsersList('active');
            $gigCategories = GigCategory::getCategoryList('active');
            $availableVisualChat = Myclass::getYesOrNo();
            ?>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'tutor_id'); ?>
                <?php echo $form->dropDownList($model, 'tutor_id', $tutors, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php echo $form->error($model, 'tutor_id'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                <?php echo $form->labelEx($model, 'gig_title'); ?>
                <?php echo $form->error($model, 'gig_title'); ?>
            </div>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'cat_id'); ?>
                <?php echo $form->dropDownList($model, 'cat_id', $gigCategories, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php echo $form->error($model, 'cat_id'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_media', array('class' => 'form-control', 'size' => 60, 'maxlength' => 500)); ?>
                <?php echo $form->labelEx($model, 'gig_media'); ?>
                <?php echo $form->error($model, 'gig_media'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_tag', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'gig_tag'); ?>
                <?php echo $form->error($model, 'gig_tag'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textArea($model, 'gig_description', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'gig_description'); ?>
                <?php echo $form->error($model, 'gig_description'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_duration', array('class' => 'form-control time')); ?>
                <?php echo $form->labelEx($model, 'gig_duration'); ?>
                <?php echo $form->error($model, 'gig_duration'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_price', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->labelEx($model, 'gig_price'); ?>
                <?php echo $form->error($model, 'gig_price'); ?>
            </div>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'gig_avail_visual'); ?>
                <?php echo $form->dropDownList($model, 'gig_avail_visual', $availableVisualChat, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php echo $form->error($model, 'gig_avail_visual'); ?>
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

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/mask.min.js', $cs_pos_end);

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $(".time").mask("99:99");
    });

EOD;

Yii::app()->clientScript->registerScript('gig_create', $js);
?>