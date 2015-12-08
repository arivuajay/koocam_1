<?php
$ajaxRun = Yii::app()->createAbsoluteUrl('/site/default/ajaxrun');
$js = <<< EOD
    jQuery(document).ready(function ($) {
        window.setInterval(function(){
            $.ajax({
                type: 'POST',
                dataType: 'json',
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
                },
                error: function(data) {
                },
            });
        }, 5000);
    });


EOD;

Yii::app()->clientScript->registerScript('_ajaxrun', $js);
?>
<div class="modal fade" id="learner-wait" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Your Learner Comes to Online !!! </h4>
            </div>
            <div class="modal-body">
                <div class="booking-form-cont">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                                <div id="learner-wait-thumb"></div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-5 ">
                                <div id="learner-wait-name"></div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">
                                <div id="learner-wait-link"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>