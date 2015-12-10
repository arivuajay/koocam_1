<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->title = 'View User';
$this->breadcrumbs = array(
    'Users' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/user/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> Send Message', 'javascript:void(0)', array("class" => "btn btn-info", 'data-toggle' => "modal", 'data-target' => "#modal-approve-withdraw", 'data-dismiss' => ".bs-example-modal-sm")); ?>
    <div class="page-section third">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'nullDisplay' => '-',
            'attributes' => array(
                'username',
                'email',
                array(
                    'name' => 'Profile Picture',
                    'type' => 'raw',
                    'value' => $model->getProfilethumb(array('class' => '', 'style' => 'height: 80px;'))
                ),
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'value' => $model->status == 1 ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
                ),
                'userProf.prof_firstname',
                'userProf.prof_lastname',
                'userProf.prof_tag',
                'userProf.prof_address',
                'userProf.prof_phone',
                'userProf.prof_skype',
                'userProf.prof_website',
                'userProf.prof_about',
                'created_at',
            ),
        ));
        ?>

    </div>
</div>

<div class="modal grow modal-backdrop-white fade" id="modal-approve-withdraw">
    <div class="modal-dialog modal-large">
        <div class="v-cell">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-approve-title">Send Message to <?php echo $model->fullname; ?></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'message-form',
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    echo $form->hiddenField($notifn_model, 'user_id', array('value' => $model->user_id));
                    echo $form->hiddenField($notifn_model, 'notifn_type', array('value' => 'admin'));
                    ?>

                    <?php echo $form->errorSummary($notifn_model); ?>
                    <div class = "form-group form-control-material static textarea-div">
                        <?php echo $form->textArea($notifn_model, 'notifn_message', array('class' => 'form-control')); ?>
                        <?php echo $form->labelEx($notifn_model, 'notifn_message'); ?>
                        <?php echo $form->error($notifn_model, 'notifn_message'); ?>
                    </div>
 
                    <div class="form-group">
                        <?php echo CHtml::submitButton('Send Message', array('class' => 'btn btn-primary')); ?>
                    </div>

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
    </div>
</div>