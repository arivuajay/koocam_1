<div class="modal fade bs-example-modal-fg2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Forgot Password </h4>
            </div>
            <div class="modal-body" id="mail-form">
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
                    <?php
                    echo CHtml::ajaxSubmitButton(
                            'Forgot Password', array('/site/default/forgotpassword'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'success' => 'function(data) {
                            process_forgot_form(data);
                        }'
                            ), array('class' => 'btn btn-default btn-lg explorebtn form-btn', 'name' => 'sign_in')
                    );
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>

            <div class="modal-body hide" id="security-form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'forgot-password-security-form',
                    'action' => array('/site/default/forgotpasswordsecurity'),
                    'htmlOptions' => array('role' => 'form', 'class' => ''),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => true,
                ));
                ?>
                <div class="form-group"> 
                    <?php echo $form->hiddenField($model, 'security_question_id', array('autofocus', 'class' => 'form-control', 'placeholder' => "Email Address")); ?> 
                    <?php echo $form->hiddenField($model, 'email', array('autofocus', 'class' => 'form-control', 'placeholder' => "Email Address", "id" => 'security_email')); ?> 
                    <?php echo $form->hiddenField($model, 'answer', array('autofocus', 'class' => 'form-control', 'placeholder' => "Email Address", "id" => 'security_answer')); ?> 
                    <span id="question-name"></span>
                    <?php echo $form->error($model, 'security_question_id'); ?> 
                    <?php echo $form->error($model, 'email'); ?> 
                    <?php echo $form->error($model, 'answer'); ?> 
                </div>
                <div class="form-group"> 
                    <?php echo $form->textField($model, 'answer_check', array('autofocus', 'class' => 'form-control', 'placeholder' => "Your security question")); ?> 
                    <?php echo $form->error($model, 'answer_check'); ?> 
                </div>

                <div class="form-group"> 
                    <?php
                    echo CHtml::ajaxSubmitButton(
                            'Forgot Password', array('/site/default/forgotpasswordsecurity'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'success' => 'function(data) {
                            process_security_form(data);
                        }'
                            ), array('class' => 'btn btn-default btn-lg explorebtn form-btn', 'name' => 'sign_in_security')
                    );
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>

        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$js = <<< EOD
                
    function process_forgot_form(data){
        if(data.status=="success"){
            $("#mail-form").addClass("hide");
            $("#security-form").removeClass("hide");
            $("#question-name").html(data.question);
            $("#LoginForm_security_question_id").val(data.question_id);
            $("#security_email").val(data.email);
            $("#security_answer").val(data.answer);
        } else{
            $.each(data, function(key, val) {
                $("#forgot-password-form #"+key+"_em_").text(val);                                                    
                $("#forgot-password-form #"+key+"_em_").show();
            });
        }
        return false;
    }
        
    function process_security_form(data){
        if(data.status=="success"){
           window.location.href = data.resetlink;
        } else{
            $.each(data, function(key, val) {
                $("#forgot-password-security-form #"+key+"_em_").text(val);                                                    
                $("#forgot-password-security-form #"+key+"_em_").show();
            });
        }
        return false;
    }

EOD;
Yii::app()->clientScript->registerScript('_forgot_section', $js);
?>