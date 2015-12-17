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
        <div class="tabbable">
            <!-- Tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#user" data-toggle="tab"><i class="fa fa-fw fa-user"></i> User Details</a></li>
                <li><a href="#cams" data-toggle="tab"><i class="fa fa-fw fa-wechat"></i> Cams</a></li>
                <li><a href="#cam_purchase" data-toggle="tab"><i class="fa fa-fw fa-cart-plus"></i> Purchase</a></li>
                <li><a href="#cam_jobs" data-toggle="tab"><i class="fa fa-fw fa-calendar"></i> Jobs</a></li>
                <li><a href="#payments" data-toggle="tab"><i class="fa fa-fw fa-money"></i> Payments</a></li>
            </ul>
            <!-- Panes -->
            <div class="tab-content">
                <div id="user" class="tab-pane active">
                    <?php $this->renderPartial('_view', compact('model')); ?>
                </div>
                <div id="cams" class="tab-pane">
                    <?php $this->renderPartial('_cam', compact('cam_model')); ?>
                </div>
                <div id="cam_purchase" class="tab-pane">
                    <?php $this->renderPartial('_purchase', compact('purchase_model')); ?>
                </div>
                <div id="cam_jobs" class="tab-pane">
                    <?php $this->renderPartial('_jobs', compact('job_model')); ?>
                </div>
                <div id="payments" class="tab-pane">
                    <?php $this->renderPartial('_payments', compact('payments_model')); ?>
                </div>
            </div>
            <!-- // END Panes -->
        </div>

    </div>
</div>

<div class="modal grow modal-backdrop-white fade" id="modal-approve-withdraw">
    <div class="modal-dialog modal-large">
        <div class="v-cell">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-approve-title">Send Message to <?php echo $model->username; ?></h4>
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