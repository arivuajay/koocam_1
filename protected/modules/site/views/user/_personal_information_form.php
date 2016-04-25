<div class="modal fade" id="edit_personal_information" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Edit Personal Information </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-personal-info-form',
                        'action' => $this->createUrl('/site/user/editpersonalinformaiton'),
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->labelEx($user_profile, 'prof_firstname'); ?>
                            <?php echo $form->textField($user_profile, 'prof_firstname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Firstname")); ?>
                            <?php echo $form->error($user_profile, 'prof_firstname'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->labelEx($user_profile, 'prof_lastname'); ?>
                            <?php echo $form->textField($user_profile, 'prof_lastname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Lastname")); ?>
                            <?php echo $form->error($user_profile, 'prof_lastname'); ?>
                        </div>
                    </div>
                    
                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($user_profile, 'prof_address'); ?>
                            <?php echo $form->textField($user_profile, 'prof_address', array('class' => 'form-control', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Address")); ?>
                            <?php echo $form->error($user_profile, 'prof_address'); ?>
                        </div>
                    </div>
                    
                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->labelEx($user_profile, 'prof_phone'); ?>
                            <?php echo $form->textField($user_profile, 'prof_phone', array('class' => 'form-control numberonly', 'size' => 30, 'maxlength' => 30, 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Phone number")); ?>
                            <?php echo $form->error($user_profile, 'prof_phone'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->labelEx($user_profile, 'prof_website'); ?>
                            <?php echo $form->textField($user_profile, 'prof_website', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100, 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Ex. http://abc.com")); ?>
                            <?php echo $form->error($user_profile, 'prof_website'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                            <?php echo CHtml::submitButton('Done', array('class' => 'btn btn-default btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>

<?php 
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $(".numberonly").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
               return false;
        });
    });

EOD;

Yii::app()->clientScript->registerScript('_personal_information_form', $js);
?>