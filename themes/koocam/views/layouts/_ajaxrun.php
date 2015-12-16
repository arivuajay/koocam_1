<?php
$ajaxRun = Yii::app()->createAbsoluteUrl('/site/default/ajaxrun');
$clock_html = '<span> %M </span> : <span>  %S </span>';
$logout_url = Yii::app()->createAbsoluteUrl('/site/default/logout');
$stay_url = Yii::app()->createAbsoluteUrl('/site/default/stayloggedin');
$user_id = (!Yii::app()->user->isGuest) ? Yii::app()->user->id : '0';

$js = <<< EOD
    jQuery(document).ready(function ($) {
        
        window.setInterval(function(){
            msg_count = $('#li_message_top').find('#top_msg_count').data('count');
            notifn_count = $('#li_notifn_top').find('#top_notifn_count').data('count');
            idle_open = $("#idle-warning").is(":visible") ? 1 : 0;
            user_sts = $('#switch_status').data('mode');
        
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'old_msg_count': msg_count, 'old_notifn_count' : notifn_count, 'idle_open' : idle_open, 'old_live_status' : user_sts},
                url: '$ajaxRun',
                success:function(data){
                    if(data.learner_waiting == 1){
                        $('#learner-wait-thumb').html(data.learner_thumb);
                        $('#learner-wait-name').html(data.learner_name);
                        $('#learner-wait-link').html(data.learner_link);
                        if ($("#learner-wait").data('bs.modal') && $("#learner-wait").data('bs.modal').isShown){
                            return;
                        }else{
                            $('#learner-wait').modal('show');
                        }
                    }
        
                    if(data.update_notification_count == 1){
                        $('#li_notifn_top').html(data.notification_update);
                    }
        
                    if(data.update_message_count == 1){
                        $('#li_message_top').html(data.message_update);
                    }
        
                    if(data.system_alert != 0){
                        $('#li_notifn_alert').html(data.system_alert);
                    }
        
                    if(data.new_live_status != 0){
                        $('#user_status_li').html(data.new_live_status);
                        $('[data-toggle="tooltip"]').tooltip();
                    }
        
                    if(data.tutor_before_paypal_alert == 1){
                        $('#tutor_before_paypal_user_name').html(data.tutor_before_paypal_user_name);
                        $('#tutor_before_paypal_user_thumb').html(data.tutor_before_paypal_user_thumb);
                        $('#tutor_before_paypal_cam_name').html(data.tutor_before_paypal_cam_name);
                        $('#tutor_before_paypal_approve').html(data.tutor_before_paypal_approve);
                        $('#tutor_before_paypal_reject').html(data.tutor_before_paypal_reject);
        
                        var clock_html = '$clock_html';
                        var end_time = data.tutor_before_paypal_countdown;
                        $('#tutor_clock').countdown(end_time, function (event) {
                            $(this).html(event.strftime(clock_html));
                        }).on('finish.countdown', function(event){
                            $('#tutor-before-paypal-wait').modal('hide');
                        });
        
                        if ($("#tutor-before-paypal-wait").data('bs.modal') && $("#tutor-before-paypal-wait").data('bs.modal').isShown){
                            return;
                        }else{
                            $('#tutor-before-paypal-wait').modal('show');
                        }
                    }
        
                    if(data.end_learner_chat == 1){
                        if($('#hidden_disconnect').length){
                            $('#hidden_disconnect').trigger('click');
                        }
                    }
        
                    if(data.end_tutor_chat == 1){
                        if($('#hidden_disconnect').length){
                            $('#hidden_disconnect').trigger('click');
                        }
                    }
        
                    if(data.idle_warning == 1){
                        var t_clock_html = '$clock_html';
                        var t_end_time = data.idle_warning_countdown;
                        $('#logout_clock').countdown(t_end_time, function (event) {
                            $(this).html(event.strftime(t_clock_html));
                        }).on('finish.countdown', function(event){
                            $('#idle-warning-message').html('Session Time Expired.. You are logged out.');
                            $.ajax({
                                type: 'POST',
                                url: '$logout_url',
                                data:data,
                                success:function(data){
                                    $('#stay_loggedin').addClass('hide');
                                    $('.after_logout').removeClass('hide');
                                },
                                error: function(data) {
                                },
                            });
                        });
        
                        if ($("#idle-warning").data('bs.modal') && $("#idle-warning").data('bs.modal').isShown){
                            return;
                        }else{
                            $('#idle-warning').modal('show');
                        }
                    }
                },
                error: function(data) {
                },
            });
        }, 5000);
        
        $('#login_again').on('click', function(){
            $('#idle-warning').modal('toggle');
        });
        
        $('#stay_loggedin').on('click', function(){
            $('#logout_clock').countdown('stop');
            $.ajax({
                type: 'POST',
                url: '$stay_url',
                data:{'user_id' : $user_id},
                success:function(data){
                    $('#idle-warning').modal('toggle');
                },
                error: function(data) {
                },
            });
        });
        
        $("#idle-warning").on('show.bs.modal', function () {
            titleBlink("Your Session Going to Expire");
        });
        $("#learner-wait").on('show.bs.modal', function () {
            titleBlink("Your Learner Comes to Online !!!");
        });
        $("#tutor-before-paypal-wait").on('show.bs.modal', function () {
            titleBlink("Payment Approve !!!");
        });
    });

    function titleBlink(txt){
        $.titleAlert(txt, {
            requireBlur:false,
            stopOnFocus:true,
            interval:700,
        });
    }

EOD;

Yii::app()->clientScript->registerScript('_ajaxrun', $js);
?>

<div id="li_notifn_alert" class="hide"></div>

<div class="modal fade approve" id="idle-warning" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close" data-backdrop="static" data-keyboard="false"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title" id="myModalLabel">  Your Session Going to Expire !!!  </h4>
            </div>
            <div class="modal-body">
                <div class="approve-img">  
                    <p class="row"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-right approve-time ">   
                        <p> <a href="#" class="btn btn-default"> <b id="logout_clock"></b></a> </p> 
                    </div>
                    <div class="clearfix"></div>
                    <p> <h4 id="idle-warning-message">Kindly Click the below link and Stay Logged in.. Otherwise you will be logged out within 15 seconds.</h4> </p>
                    <div class="form-group">
                        <div class="row"> 
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-12">                
                                <?php echo CHtml::link('Stay Logged in', '', array('class' => 'btn btn-danger', 'id' => 'stay_loggedin')); ?>
                                <?php echo CHtml::link('Login', '#', array('data-toggle' => "modal", 'data-target' => ".bs-example-modal-sm1", 'data-dismiss' => "#idle-warning", 'id' => 'login_again', 'class' => 'hide btn btn-primary after_logout')); ?>
                                <?php echo CHtml::link('Refresh', Yii::app()->controller->homeUrl, array('data-toggle' => "modal", 'class' => 'hide btn btn-success after_logout')); ?>
                            </div> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade approve" id="learner-wait" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">  Your Learner Comes to Online !!!  </h4>
            </div>
            <div class="modal-body">
                <div class="approve-img">  
                    <p class="row"> 
                    <div class="clearfix"></div>
                    <p id="learner-wait-thumb"> </p>
                    <p> <h2 id="learner-wait-name"></h2> </p>
                    <div class="form-group">
                        <div class="row"> 
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-12" id="learner-wait-link"></div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade approve" id="tutor-before-paypal-wait" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">  Approve ? </h4>
            </div>
            <div class="modal-body">

                <div class="approve-img">  
                    <p class="row"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-right approve-time ">   
                        <p> <a href="#" class="btn btn-default"> <b id="tutor_clock"></b></a> </p> 
                    </div>
                    <div class="clearfix"></div>
                    <p id="tutor_before_paypal_user_thumb"> </p>
                    <p> <h2 id="tutor_before_paypal_user_name"></h2> </p>
                    <p> <h4><b>  Cam Name :  </b> <span id="tutor_before_paypal_cam_name"></span> </h4> </p>
                    <div class="form-group">
                        <div class="row"> 
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="tutor_before_paypal_approve"></div> 
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 " id="tutor_before_paypal_reject"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/jquery.countdown.min.js', $cs_pos_end);
?>