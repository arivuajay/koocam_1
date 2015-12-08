<div class="modal fade" id="edit_email_address" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Edit Email Address </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-email-address-form',
                        'action' => $this->createUrl('/site/user/editemailaddress'),
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($model, 'email'); ?>
                            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>
                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($model, 'confirm_password'); ?>
                            <?php echo $form->passwordField($model, 'confirm_password', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                            <?php echo $form->error($model, 'confirm_password'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
                            <?php echo CHtml::submitButton('Edit', array('class' => 'btn btn-default btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>