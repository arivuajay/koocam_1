<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $token GigTokens */
/* @var $form CActiveForm */
$this->title = 'Chat';
$themeUrl = $this->themeUrl;
$show_video = $token->book->gig->gig_avail_visual == 'Y' ? 'true' : 'false';
$this->renderPartial('_report_abuse', compact('token', 'abuse_model', 'info'));
$this->renderPartial('/gig/_comments_form', array('model' => $token->book->gig, 'gig_comments' => $gig_comments));
?>
<div id="inner-banner" class="tt-fullHeight3 chat-banner">
    <div class="container homepage-txt">
        <div class="row">

        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="hide">
            <?php
            $encpt_url = Yii::app()->createAbsoluteUrl('/site/default/filecrypt');
            $guid = $token->book->book_guid;
            $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                'id' => 'uploadFile',
                'config' => array(
                    'action' => Yii::app()->createUrl('/site/default/upload'),
//                                            'allowedExtensions' => array("jpg","jpeg","gif","exe","mov"),
                    'sizeLimit' => 5 * 1024 * 1024,
//                                            'minSizeLimit' => 10 * 1024 * 1024,
                    'onComplete' => "js:function(id, fileName, responseJSON){
            $.ajax({
                type: 'POST',
                url: '$encpt_url',
                data: {file: responseJSON.filename, guid: '{$guid}'},
                success:function(url){
                    $('#btn-input').val(url);
                    $('#chat-form').submit();
                    $('#btn-input').val('');
                },
                error: function(data) {
                },
            });

            }",
                    'messages' => array(
                        'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                        'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                        'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                        'emptyError' => "{file} is empty, please select files again without it.",
                        'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
                    ),
                //'showMessage'=>"js:function(message){ alert(message); }"
                )
            ));
            ?>
        </div>
        <?php
        echo CHtml::tag('div', array('id' => 'errorDiv', 'class' => 'text-danger', 'style' => 'word-wrap: break-word;'), '');
        $this->widget('ext.yii-opentok.EOpenTokWidget', array(
            'key' => Yii::app()->tok->key,
            'sessionId' => $token->session_key,
            'token' => $token->token_key,
            'show_video' => $show_video,
            'my_name' => $info['my_name'],
            'their_name' => $info['their_name'],
            'my_thumb' => $info['my_thumb'],
            'their_thumb' => $info['their_thumb'],
            'token_id' => $token->token_id,
        ));
        ?>
        <div class="row" id="chat_row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9 " id="p_sub_div">
                <div id="subscribersDiv" class="subscriber-div"></div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 ">
                <div class="chat-right2"> 
                    <div class="chat-right">
                        <div class="my-chat">
                            <div id="myPublisherDiv"></div>
                        </div>
                        <div id="time-alert" class="text-white hide"><span class="blink">Time going to End !!!</span></div>
                        <div class="chat-count" id="clock">
                            <div class="hour">  Hour  <br/>  <span>00</span></div>
                            <div class="hour">  Min  <br/>  <span>00</span></div>
                            <div class="hour"> Sec  <br/> <span>  00</span></div>
                        </div>
                        <div class="chat-btns-cont">
                            <div class="row"> 
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
                                    <?php echo CHtml::link('hidden_disconnect', 'javascript:void(0)', array('id' => 'hidden_disconnect', 'class' => 'hide')); ?>
                                    <?php echo CHtml::link(CHtml::image($themeUrl . '/images/callend.png'), 'javascript:void(0)', array('id' => 'disconnect')); ?>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
                                    <?php
                                    echo CHtml::link(CHtml::image($themeUrl . '/images/report.png'), 'javascript:void(0)', array('class' => '', 'data-toggle' => "modal", 'data-target' => "#abuse-modal"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-cht">
                    <?php echo CHtml::form('', 'post', array('id' => 'chat-form')); ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Chat
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs " data-toggle="dropdown" id="send-file-button">
                                    <i class="fa fa-send"></i> Send File
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="chat" id="msgHistory">
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <div class="input-group">
                                <?php echo CHtml::textField('text-chat', '', array('class' => "form-control input-sm", 'placeholder' => "Type your message here...", 'id' => 'btn-input')); ?>
                                <span class="input-group-btn">
                                    <?php echo CHtml::submitButton('Send', array('class' => "btn btn-warning btn-sm", 'id' => "btn-chat")); ?>
                                </span>
                            </div>
                            <div id="chat_input_error" class="text-danger hide">Enter some text to chat !!! </div>
                        </div>
                    </div>
                    <?php echo CHtml::endForm(); ?>
                </div>
            </div>
        </div>
        
        <div class="row hide" id="after_chat">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-12 text-center">
                <p>Your Chat Completed Successfully !!!</p>
                <br />
                <div>
                    <?php echo CHtml::link('Go to Home', array('/site/default/index'), array('class' => 'btb btn-lg btn-success')); ?>
                </div>
            </div>
            
        </div>
        <br />
        <!--            <div id="msgHistory"></div>
                    <a href="javascript:void(0)" id="connect" class="hide">Connect Again</a>-->
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("https://static.opentok.com/v2/js/opentok.min.js");
$cs->registerScriptFile($themeUrl . '/js/moment.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/moment-timezone.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery.countdown.min.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery-blink.js', $cs_pos_end);

$end_time = date('Y/m/d H:i:s', strtotime(Yii::app()->localtime->toUTC($token->book->book_end_time)));
$time_zone = Yii::app()->localtime->getTimeZone();
$alert_minute = 2;
$clock_html = '<div class="hour">  Hour  <br/>  <span>%H</span></div></div><div class="hour">  Min  <br/>  <span>%M</span></div><div class="hour"> Sec  <br/> <span>  %S</span></div>';

$js = <<< EOD
    jQuery(document).ready(function ($) {
        var alert_min = '$alert_minute';
        var clock_html = '$clock_html';
        var end_time = moment.tz("{$end_time}", "{$time_zone}");
        $('#clock').countdown(end_time.toDate(), function (event) {
            $(this).html(event.strftime(clock_html));
        }).on('update.countdown', function(event) {
            if(alert_min >= event.offset.minutes && event.offset.hours == 0){
                $('#time-alert').removeClass('hide');
            }
        }).on('finish.countdown', function(event){
            $('#hidden_disconnect').trigger('click');
        });
        $('.blink').blink({delay:300});
    });

    $('#send-file-button').on('click', function(){
        $('#uploadFile :input').trigger('click');
    });
    
EOD;
Yii::app()->clientScript->registerScript('chat', $js);
?>
