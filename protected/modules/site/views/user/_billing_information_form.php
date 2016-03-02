<div class="modal fade" id="edit_billing_information" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Edit Billing Information </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-billing-info-form',
                        'action' => $this->createUrl('/site/user/editbillinginformaiton'),
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->checkBox($user_profile, 'receive_invoice_email'); ?>
                            <?php echo $form->labelEx($user_profile, 'receive_invoice_email'); ?>
                            <?php echo $form->error($user_profile, 'receive_invoice_email'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->labelEx($user_profile, 'company_name'); ?>
                            <?php echo $form->textField($user_profile, 'company_name', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Company Name")); ?>
                            <?php echo $form->error($user_profile, 'company_name'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->labelEx($user_profile, 'company_id'); ?>
                            <?php echo $form->textField($user_profile, 'company_id', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50, 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Company ID")); ?>
                            <?php echo $form->error($user_profile, 'company_id'); ?>
                        </div>
                    </div>

                    <div class = "form-group form-control-material static">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($user_profile, 'company_address'); ?>
                            <?php echo $form->textField($user_profile, 'company_address', array('class' => 'form-control', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Your Company Address")); ?>
                            <?php echo $form->error($user_profile, 'company_address'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                            <?php echo CHtml::submitButton('Edit', array('class' => 'btn btn-default btn-lg explorebtn form-btn')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>

            </div>
        </div>
    </div>
</div>