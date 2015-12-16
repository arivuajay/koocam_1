<?php
/* @var $this CamController */
/* @var $temp_booking BookingTemp */
/* @var $form CActiveForm */
$this->title = 'Waiting for Chat';
$themeUrl = $this->themeUrl;
?>
<div id="inner-banner" class="tt-fullHeight3 chat-banner">
    <div class="container homepage-txt">
        <div class="row">
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3  col-lg-offset-3 prebooking-cont ">
                <h2> Chat Progress </h2>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 prebooking-cont ">
                <div class="prebooking-details">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12" id="prog_sts"><?php echo $temp_booking->progress; ?></div>
                </div>
            </div>
<!--            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 prebooking-cont ">
                <div class="prebooking-details">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">  <b> Tutor Name  : </b>  <a href="#">Lorem ipsum</a></div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-7">  <b> Gig  Name  : </b>  <a href="#">Do You speak english?</a></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 prebooking-date">   <h2> Your Booking Date &  Time : 15.00  , Nov 15  </h2></div>
                    <div class="explore-btn"> <a class="btn btn-default  btn-lg explorebtn " href="#"> <i class="fa fa-money"></i> Pay Now</a> </div>
                </div>
            </div>-->
        </div>
    </div>
</div>
<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$ipn_check_url = Yii::app()->createAbsoluteUrl('/site/default/ipncheck', array('temp_guid' => $temp_booking->temp_guid));

$js = <<< EOD
    jQuery(document).ready(function ($) {
        window.setInterval(function(){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '$ipn_check_url',
                data:{'temp_guid' : '{$temp_booking->temp_guid}'},
                success:function(data){
                    $('#prog_sts').html(data.status_txt);
                    if(data.status == 'C'){
                        window.location.href = data.chat_url;
                    }
                },
                error: function(data) {
                },
            });
        }, 1000);
    });
    
EOD;
Yii::app()->clientScript->registerScript('prechat', $js);
?>
