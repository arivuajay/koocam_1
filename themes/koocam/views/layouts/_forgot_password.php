<div class="modal fade bs-example-modal-fg2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Forgot Password </h4>
            </div>
            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'forgot-password-form',
                            'action' => array('/site/default/forgotpassword'),
                            'htmlOptions' => array('role' => 'form', 'class' => ''),
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'enableAjaxValidation' => true,
                        ));
                ?>
                <div class="form-group"> 
                    <?php echo $form->textField($model, 'email', array('autofocus', 'class' => 'form-control', 'placeholder' => "Email Address")); ?> 
                    <?php echo $form->error($model, 'email'); ?> 
                </div>
                
                <div class="form-group forgot-password"> 
                    <a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1" data-dismiss=".bs-example-modal-sm2" id="forgot-login-button"> Login ? </a> 
                </div>
                <div class="form-group"> 
                    <?php echo CHtml::submitButton('Forgot Password', array('class' => 'btn btn-default btn-lg explorebtn form-btn', 'name' => 'sign_in')) ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>