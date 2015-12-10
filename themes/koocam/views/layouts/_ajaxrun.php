<?php
$ajaxRun = Yii::app()->createAbsoluteUrl('/site/default/ajaxrun');
$clock_html = '<span> %M </span> : <span>  %S </span>';

$js = <<< EOD
    jQuery(document).ready(function ($) {
        window.setInterval(function(){
            msg_count = $('#li_message_top').find('#top_msg_count').data('count');
            notifn_count = $('#li_notifn_top').find('#top_notifn_count').data('count');
        
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'old_msg_count': msg_count, 'old_notifn_count' : notifn_count},
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
        
                    if(data.tutor_before_paypal_alert == 1){
                        $('#tutor_before_paypal_user_name').html(data.tutor_before_paypal_user_name);
                        $('#tutor_before_paypal_user_thumb').html(data.tutor_before_paypal_user_thumb);
                        $('#tutor_before_paypal_gig_name').html(data.tutor_before_paypal_gig_name);
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
                },
                error: function(data) {
                },
            });
        }, 5000);
    });


EOD;

Yii::app()->clientScript->registerScript('_ajaxrun', $js);
?>

<div class="modal fade approve" id="learner-wait" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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

<div class="modal fade approve" id="tutor-before-paypal-wait" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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
                    <p> <h4><b>  Gig Name :  </b> <span id="tutor_before_paypal_gig_name"></span> </h4> </p>
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