<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $token CamTokens */
/* @var $form CActiveForm */
$this->title = 'Pre Booking';
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
        <div class="row" id="after_chat">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-12 text-center">
                <p>Welcome</p>
                <br />
                <div>
                    Your booking will open <br> <span id="clock"></span>
                </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-12 text-center hide" id="display_startnow">
                <a href="#" data-target="#prebookingstartnow" data-toggle="modal" class="big-btn btn btn-default">
                    <i class="fa fa-video-camera"></i> Start Now !
                </a>
            </div>
        </div>
    </div>
</div>



<?php
$model = $booking->cam;
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cam-startnow-form',
    'action' => array('/site/bookingtemp/booking'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => false,
    ),
    'enableAjaxValidation' => true,
        ));

echo $form->hiddenField($booking_temp, 'temp_cam_id', array('value' => $model->cam_id));
echo $form->hiddenField($booking_temp, 'temp_book_session', array('value' => $booking->book_session));
echo $form->hiddenField($booking_temp, 'temp_book_is_extra', array('value' => $booking->book_is_extra));

$cam_price = (int) $model->cam_price;

if ($booking->book_is_extra == "Y") {
    $extra_price = isset($model->camExtras->extra_price) ? (int) $model->camExtras->extra_price : 0;
} else {
    $extra_price = 0;
}

$user_country_id = Yii::app()->user->country_id;
$price_calculation = CamBooking::price_calculation($user_country_id, $cam_price, $extra_price);
?>

<div class="modal fade" id="prebookingstartnow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $model->cam_title; ?></h4>
            </div>
            <div class="modal-body">
                <div class="booking-form-cont">
                    <div class="row">

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <?php echo $form->labelEx($booking_temp, 'temp_book_session'); ?>
                                <?php echo $booking->book_session; ?>
                            </div>
                        </div>

                        <?php if ($booking->book_is_extra == "Y") { ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="cam-extras">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <h2> Extras </h2>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 extras-txt">
                                            <?php echo $model->camExtras->extra_description; ?>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
                                            <div id="extras-prices" class="temp_extras-prices-bg">
                                                <?php echo $extra_price; ?> $
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <h4 class="temp-total-price"> Price : $ <span id="price"><?php echo $price_calculation['total_price']; ?></span></h4>
                                <span>Incl. Processing Fee: $ <span id="processing_fee"><?php echo $price_calculation['processing_fees']; ?></span></span>
                                <?php if ($price_calculation['service_tax'] > 0)  ?>
                                <br><span>Incl. Service Tax: $ <span id="service_tax"><?php echo $price_calculation['service_tax']; ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" id="start-now-buttons">
                <?php
                echo CHtml::ajaxSubmitButton(
                        'Pay Now !', array('/site/bookingtemp/booking'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'success' => 'function(data) {
                            process_startnow_form(data);
                        }'
                        ), array('class' => 'btn btn-red')
                );
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/jquery.countdown.min.js', $cs_pos_end);

$end_time = date('Y/m/d H:i:s', strtotime($booking->book_start_time));

$clock_html = '<div class="hour">  Hour  <br/>  <span>%H</span></div></div><div class="hour">  Min  <br/>  <span>%M</span></div><div class="hour"> Sec  <br/> <span>  %S</span></div>';

$new_clock_html = '<span> %M </span> : <span>  %S </span>';

$cancel_booking = Yii::app()->createAbsoluteUrl('/site/bookingtemp/cancelbooking/temp_guid/');
$ajaxRun_user = Yii::app()->createAbsoluteUrl('/site/default/ajaxrunuser');
$paypal_process = Yii::app()->createAbsoluteUrl('/site/bookingtemp/processpaypal/temp_guid/');
$book_id = $booking->book_id;

$js = <<< EOD
    jQuery(document).ready(function ($) {
        var clock_html = '$clock_html';
        var end_time = '$end_time';
        
        $('#clock').countdown(end_time, function (event) {
            $(this).html(event.strftime(clock_html));
        }).on('update.countdown', function(event) {
//            if(alert_min > event.offset.minutes && event.offset.hours == 0){
//                $('#time-alert').removeClass('hide');
//            }
        }).on('finish.countdown', function(event){
            $('#display_startnow').removeClass('hide');
        });
    });
        
    function process_startnow_form(data){
        var book_id = $book_id;
        if(data.status=="success"){
            var temp_guid = data.temp_guid;
            $("#start-now-buttons").html("Please wait <span id='new_clock'></span> min, while tutor will approve your booking...");
                
            var clock_html = '$new_clock_html';
            var end_time = data.end_time_format;
            $('#new_clock').countdown(end_time, function (event) {
                $(this).html(event.strftime(clock_html));
            }).on('update.countdown', function(event) {
                if(1 >= event.offset.seconds && event.offset.minutes == 0){
                    window.location = '{$cancel_booking}' + '/' + temp_guid;
                }

                if(event.offset.seconds % 5 == 0 || event.offset.seconds == 0){
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {'temp_guid': data.temp_guid},
                        url: '$ajaxRun_user',
                        success:function(data){
                            if(data.user_before_paypal_status == "success"){ 
                                window.location = '{$paypal_process}' + '/' + temp_guid + '/book_id/' + book_id;
                            }
                            if(data.user_before_paypal_status == "rejected"){
                                alert("You booking is rejected by Tutor, Please try again");
                                location.reload();
                            }
                        },
                        error: function(data) {
                        },
                    });
                }
                
            });
        } else{
            $.each(data, function(key, val) {
                $("#cam-startnow-form #"+key+"_em_").text(val);                                                    
                $("#cam-startnow-form #"+key+"_em_").show();
            });
        }
        return false;
    }

EOD;
Yii::app()->clientScript->registerScript('prebooking', $js);
?>
