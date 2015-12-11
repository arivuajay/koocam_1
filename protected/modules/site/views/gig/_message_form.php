<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $message Message */
?>

<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Message </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'message-form',
                        'action' => $this->createUrl('/site/gig/sendmessage'),
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($message, 'message'); ?>
                            <?php echo $form->textArea($message, 'message', array('class' => 'form-control allow_foriegn', 'rows' => 3, 'cols' => 50)); ?>
                            <?php echo $form->error($message, 'message'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static hide">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($message, 'gig_id'); ?>
                            <?php echo $form->hiddenField($message, 'gig_id', array('class' => 'form-control', 'rows' => 3, 'cols' => 50, 'value' => $model->gig_id)); ?>
                            <?php echo $form->error($message, 'gig_id'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
                            <?php echo CHtml::submitButton('Send Message', array('class' => 'btn btn-default btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>