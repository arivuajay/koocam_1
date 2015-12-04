<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $token GigTokens */
/* @var $form CActiveForm */
$this->title = 'Chat';
$themeUrl = $this->themeUrl;
$show_video = $token->book->gig->gig_avail_visual == 'Y' ? 'true' : 'false';
?>
<div class="body-cont">
    <div id="inner-banner" class="tt-fullHeight3">
        <div class="container homepage-txt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                </div>
            </div>
        </div>
    </div>
    <div class="innerpage-cont">
        <div class="container">
            <?php
            echo CHtml::tag('div', array('id' => 'errorDiv', 'class' => 'text-danger', 'style' => 'word-wrap: break-word;'), '');
//            $this->widget('ext.yii-opentok.EOpenTokWidget', array(
//                'key' => Yii::app()->tok->key,
//                'sessionId' => $token->session_key,
//                'token' => $token->token_key,
//                'show_video' => $show_video
//            ));
            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9 " id="subscribersDiv">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 ">
                    <div class="chat-right2"> 
                        <div class="chat-right">
                            <div class="my-chat" id="myPublisherDiv"></div>
                            <div class="chat-count">
                                <div class="hour">  Hour  <br/>  <span>01</span></div>
                                <div class="hour">  Min  <br/>  <span>15</span></div>
                                <div class="hour"> Sec  <br/> <span>  20</span></div>
                            </div>
                            <div class="chat-btns-cont">
                                <div class="row"> 
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> <a href="#"><img src="images/callend.png"  alt=""></a>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> <a href="#"><img src="images/report.png"  alt=""></a>
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
                                    <button type="button" class="btn btn-default btn-xs " data-toggle="dropdown">
                                        <i class="fa fa-send"></i> Send File
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <ul class="chat">
                                    <li class="left clearfix"><span class="chat-img pull-left">
                                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font">Jack Sparrow</strong> 
                                            </div>
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                                dolor, quis ullamcorper ligula sodales.
                                            </p>
                                        </div>
                                    </li>
                                    <li class="right clearfix"><span class="chat-img pull-right">
                                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="pull-right primary-font">Bhaumik Patel</strong> <br/>
                                            </div>
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                                dolor, quis ullamcorper ligula sodales.
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <div class="input-group">
                                    <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                    <span class="input-group-btn">
                                        <button class="btn btn-warning btn-sm" id="btn-chat">
                                            Send</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                    </div>
                </div>
            </div>
            <br />
            <div id="msgHistory"></div>
            <br />
            <form id="chat-form">
                <input type="text" placeholder="chat" id="msgTxt" class="form-control" /><br />
                <input type="submit" class="btn btn-small explorebtn" value="Send" /><br /><br />
                <?php
                $encpt_url = Yii::app()->createAbsoluteUrl('/site/default/filecrypt');
                $guid = $token->book->book_guid;
                $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                    'id' => 'uploadFile',
                    'config' => array(
                        'action' => Yii::app()->createUrl('/site/default/upload'),
//                        'allowedExtensions' => array("jpg","jpeg","gif","exe","mov"),
                        'sizeLimit' => 5 * 1024 * 1024,
//                        'minSizeLimit' => 10 * 1024 * 1024,
                        'onComplete' => "js:function(id, fileName, responseJSON){
                            $.ajax({
                                type: 'POST',
                                url: '$encpt_url',
                                data: {file: responseJSON.filename, guid: '{$guid}'},
                                success:function(url){
                                    $('#msgTxt').val(url);
                                    $('#chat-form').submit();
                                    $('#msgTxt').val('');
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
            </form>
            <hr/>
            <a href="javascript:void(0)" id="connect" class="hide">Connect Again</a>
            <br />
            <a href="javascript:void(0)" id="disconnect">DisConnect</a>
            <div id="clock"></div>
            <div id="time-alert" class="text-danger hide"><span class="blink">Time going to End !!!</span></div>
            <?php
            echo CHtml::link('Report Abuse', '#', array('class' => '', 'data-toggle' => "modal", 'data-target' => "#abuse-modal"));
            $this->renderPartial('_report_abuse', compact('token', 'abuse_model'));
            ?>
        </div>
    </div>
</div>
<!--<div id="countdowntimer"><span id="given_date"><span></div>-->
<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("https://static.opentok.com/v2/js/opentok.min.js");
$cs->registerScriptFile($themeUrl . '/js/moment.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/moment-timezone.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery.countdown.min.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery-blink.js', $cs_pos_end);
//$cs->registerScriptFile($themeUrl . '/js/jquery.countdownTimer.min.js', $cs_pos_end);
//$start_time = date('Y/m/d H:i:s', strtotime(Yii::app()->localtime->fromUTC(date('Y/m/d H:i:s'))));
//$start_date = new DateTime($start_time);
//$since_start = $start_date->diff(new DateTime(date('Y/m/d H:i:s', strtotime($token->book->book_end_time))));
$end_time = date('Y/m/d H:i:s', strtotime(Yii::app()->localtime->toUTC($token->book->book_end_time)));
$time_zone = Yii::app()->localtime->getTimeZone();
$alert_minute = 2;
$js = <<< EOD
    jQuery(document).ready(function ($) {
        var alert_min = '$alert_minute';
        
//        $("#given_date").countdowntimer({
//            hours : {$since_start->h},
//            minutes : {$since_start->i},
//            seconds : {$since_start->s},
//            size : "lg"
//	});
        
        var end_time = moment.tz("{$end_time}", "{$time_zone}");
        
        $('#clock').countdown(end_time.toDate(), function (event) {
            $(this).html(event.strftime('%H:%M:%S'));
        }).on('update.countdown', function(event) {
            if (event.elapsed) {
                $('#clock').countdown('stop');
            }else{
                if(alert_min >= event.offset.minutes){
                    $('#time-alert').removeClass('hide');
                }
            }
        });
        $('.blink').blink({delay:300});
            
        $( ".given_date" ).change(function() {
            console.log('asdsad');
        });
    });
EOD;
Yii::app()->clientScript->registerScript('chat', $js);
?>
