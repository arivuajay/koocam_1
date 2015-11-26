<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Sign Up</h4>
            </div>
            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'register-form',
                            'action' => array('/site/default/register'),
                            'htmlOptions' => array('role' => 'form', 'class' => ''),
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'enableAjaxValidation' => true,
                        ));
                ?>

                <div class="form-group"> 
                    <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control', 'placeholder' => "User Name")); ?> 
                    <?php echo $form->error($model, 'username'); ?>
                </div>
                <div class="form-group"> 
                    <?php echo $form->textField($model, 'email', array('autofocus', 'class' => 'form-control', 'placeholder' => "Email Address")); ?> 
                    <?php echo $form->error($model, 'email'); ?>
                </div>
                <div class="form-group"> 
                    <?php echo $form->passwordField($model, 'password_hash', array('placeholder' => User::model()->getAttributeLabel('password_hash'), 'class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                    <?php echo $form->error($model, 'password_hash'); ?>
                </div>
                <div class="form-group"> 
                    <?php echo $form->passwordField($model, 'confirm_password', array('placeholder' => User::model()->getAttributeLabel('confirm_password'), 'class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                    <?php echo $form->error($model, 'confirm_password'); ?>
                </div>
                <div class="form-group"> 
                    <?php echo CHtml::submitButton(' Submit', array('class' => 'btn btn-default  btn-lg explorebtn form-btn', 'name' => 'sign_in')) ?>
                </div>

                <div class="form-group">   <div class="spe"> <img src="<?php echo $this->themeUrl ?>/images/or.png" alt=""> </div> 
                    <div class="line"></div> </div>
                <div class="form-group"> <button data-provider="facebook" class="btn btn-default  btn-lg explorebtn form-btn fb-btn oAuthLogin"> <i class="fa fa-facebook"></i> Facebook</button> </div>
                <div class="form-group"> <button data-provider="google" class="btn btn-default  btn-lg explorebtn form-btn gplus-btn oAuthLogin"> <i class="fa fa-google-plus"></i> Google +</button> </div>

                <div class="form-group already-member"> Already have an account ? &nbsp;<a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1" data-dismiss=".bs-example-modal-sm" id="login-button"> <b> Login </b></a> </div>

                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>