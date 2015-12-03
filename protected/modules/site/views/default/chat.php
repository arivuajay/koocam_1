<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $token GigTokens */
/* @var $form CActiveForm */

$this->title = 'Chat';
$themeUrl = $this->themeUrl;
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
            echo '<br />';
            echo CHtml::tag('div', array('id' => 'subscribersDiv'), '');
            echo '<br />';
            echo CHtml::tag('div', array('id' => 'myPublisherDiv'), '');

            $show_video = $token->book->gig->gig_avail_visual == 'Y' ? 'true' : 'false';
            $this->widget('ext.yii-opentok.EOpenTokWidget', array(
                'key' => Yii::app()->tok->key,
                'sessionId' => $token->session_key,
                'token' => $token->token_key,
                'show_video' => $show_video
            ));
            ?>
            <br />
            <div id="msgHistory"></div>
            <br />
            <form id="chat-form">
                <input type="text" placeholder="chat" id="msgTxt" class="form-control" /><br />
                <input type="submit" class="btn btn-small explorebtn" value="Send" />
            </form>
            <hr/>
            <a href="javascript:void(0)" id="connect" class="hide">Connect Again</a>
            <br />
            <a href="javascript:void(0)" id="disconnect">DisConnect</a>

            <div id="clock"></div>
            <div id="time-alert" class="text-danger hide"><span class="blink">Time going to End !!!</span></div>
        </div>
    </div>
</div>
<div id="countdowntimer"><span id="given_date"><span></div>
            
<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("https://static.opentok.com/v2/js/opentok.min.js");
$cs->registerScriptFile($themeUrl . '/js/moment.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/moment-timezone.js', $cs_pos_end);
//$cs->registerScriptFile($themeUrl . '/js/jquery.countdownTimer.min.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery.countdown.min.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery-blink.js', $cs_pos_end);

//$start_time = date('Y/m/d H:i:s', strtotime(Yii::app()->localtime->fromUTC(date('Y/m/d H:i:s'))));
//$start_date = new DateTime($start_time);
//$since_start = $start_date->diff(new DateTime(date('Y/m/d H:i:s', strtotime($token->book->book_end_time))));

echo $end_time = date('Y/m/d H:i:s', strtotime(Yii::app()->localtime->toUTC($token->book->book_end_time)));
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
        
//        var end_time = moment.tz("{$end_time}", "Asia/Jerusalem");
        
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
