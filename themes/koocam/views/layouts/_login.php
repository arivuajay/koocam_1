<div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Login</h4>
            </div>
            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'loginss-form',
                            'action' => array('/site/default/login'),
                            'htmlOptions' => array('role' => 'form', 'class' => ''),
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'enableAjaxValidation' => true,
                        ));
                ?>

                <div class="form-group"> 
                    <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control', 'placeholder' => "User Name (or) Email Address")); ?> 
                    <?php echo $form->error($model, 'username'); ?> 
                </div>
                <div class="form-group">                             
                    <?php echo $form->passwordField($model, 'password', array('autofocus', 'class' => 'form-control', 'placeholder' => "Enter Password")); ?>
                    <?php echo $form->error($model, 'password'); ?> 
                </div>
                <div class="form-group">                             
                    <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check', 'checked' => 'checked')); ?>
                    <?php echo ' Remember Me'; ?>
                </div>
                <div class="form-group forgot-password"> <a href="#">Forgot Password ?</a></div>
                <div class="form-group"> 
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-default btn-lg explorebtn form-btn', 'name' => 'sign_in')) ?>
                </div>

                <div class="form-group">   <div class="spe"> <img src="<?php echo $this->themeUrl ?>/images/or.png" alt=""> </div> 
                    <div class="line"></div> </div>
                <div class="form-group"> <button data-provider="facebook" class="btn btn-default  btn-lg explorebtn form-btn fb-btn oAuthLogin"> <i class="fa fa-facebook"></i> Facebook</button> </div>
                <div class="form-group"> <button data-provider="google" class="btn btn-default  btn-lg explorebtn form-btn gplus-btn oAuthLogin"> <i class="fa fa-google-plus"></i> Google + </button> </div>

                <div class="form-group already-member"> Don't have an account ? &nbsp;<a href="#" data-toggle="modal" data-target=".bs-example-modal-sm" data-dismiss=".bs-example-modal-sm1" id="signup-button" onclick="$('.bs-example-modal-sm').modal('hide');"> <b> Sign up </b></a>
                </div>
                <?php $this->endWidget(); ?>


            </div>
        </div>
    </div>
</div>