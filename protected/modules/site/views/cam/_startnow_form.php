<?php
/* @var $this DefaultController */
/* @var $model Cam */
/* @var $booking_temp BookingTemp */
/* @var $form CActiveForm */
/* @var $tutor User */

$themeUrl = $this->themeUrl;
$tutor = $model->tutor;

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

$session = CamBooking::camSessionList(Yii::app()->user->id, $model->cam_id, date('Y-m-d'));
$cam_price = (float) $model->cam_price;
$extra_price = isset($model->camExtras->extra_price) ? (float) $model->camExtras->extra_price : 0;
$user_country_id = Yii::app()->user->country_id;
$price_calculation = CamBooking::price_calculation($user_country_id, $cam_price, $extra_price);
?>

<div class="modal fade" id="startnow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $model->cam_title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $form->errorSummary($booking_temp); ?>

                <div class="booking-form-cont">
                    <div class="row">

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <?php echo $form->labelEx($booking_temp, 'temp_book_session'); ?>
                                <?php echo $form->dropDownList($booking_temp, 'temp_book_session', $session, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5", 'prompt' => 'Select Session')); ?>
                                <?php echo $form->error($booking_temp, 'temp_book_session'); ?>
                            </div>
                        </div>

                        <?php if (!empty($model->camExtras)) { ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="cam-extras">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <h2> Extras </h2>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 extras-txt">
                                            <?php echo $form->checkBox($booking_temp, 'temp_book_is_extra', array('class' => 'book_extra_check', 'id' => 'temp_book_extra_inner', 'value' => 'Y', 'uncheckValue' => 'N')); ?>
                                            <?php echo $model->camExtras->extra_description; ?>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
                                            <div id="extras-prices" class="temp_extras-prices-bg" data-temp_cam_price="<?php echo $cam_price; ?>" data-temp_extra_price="<?php echo $extra_price ?>">
                                                <?php echo $extra_price; ?> $
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <h4 class="temp-total-price"> Price : $ <span id="price"></span></h4>
                                <span>Incl. Processing Fee: $ <span id="processing_fee"></span></span>
                                <?php if ($price_calculation['service_tax'] > 0)  ?>
                                <br><span>Incl. Service Tax: $ <span id="service_tax"></span></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" id="start-now-buttons">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php
                echo CHtml::ajaxSubmitButton(
                        'Start Now !', array('/site/bookingtemp/booking'), array(
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

<div class="modal fade" id="reject_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="booking-form-cont">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <span class="text-red-300">  Your booking is rejected by User, Please try again        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="reject-okay-buttons">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal" onclick="window.location.href = '<?php echo Yii::app()->request->url ?>'">Okay</button>
            </div>
        </div>
    </div>
</div>


<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$temp_sessionId = CHTML::activeId($booking_temp, 'temp_book_session');

$price_calculation_url = Yii::app()->createAbsoluteUrl('/site/cambooking/getbookingprice');
$start_now_url = Yii::app()->createAbsoluteUrl('/site/bookingtemp/booking');

$clock_html = '<span> %M </span> : <span>  %S </span>';

$ajaxRun_user = Yii::app()->createAbsoluteUrl('/site/default/ajaxrunuser');
$paypal_process = Yii::app()->createAbsoluteUrl('/site/bookingtemp/processpaypal/temp_guid/');
$cancel_booking = Yii::app()->createAbsoluteUrl('/site/bookingtemp/cancelbooking/temp_guid/');

$js = <<< EOD
    jQuery(document).ready(function ($) {
        var cam_price = $cam_price;
        var extra_price = $extra_price;
        var user_country_id = $user_country_id;
        var extra_checked = $('#temp_book_extra_inner').parent('div').hasClass('checked');
        
        $('#temp_book_extra_inner').on('ifChecked', function(event){
            camPriceBySession($("#{$temp_sessionId}").val(), true);
        });

        $('#temp_book_extra_inner').on('ifUnchecked', function(event){
            camPriceBySession($("#{$temp_sessionId}").val(), false);
        });
        
        // Session change Functions //
        $('#{$temp_sessionId}').on('change', function(){
            camPriceBySession($(this).val(), $('#temp_book_extra_inner').parent('div').hasClass('checked'));
        });
        
        camPriceBySession($("#{$temp_sessionId}").val(), extra_checked);
        
        function camPriceBySession(session_count, is_extra){
            session = session_count;
            price = 0;
            extra = is_extra ? extra_price : 0;
        
            if(session != ''){
                for (i = 0; i < session; i++) {
                    price = parseFloat(price) + parseFloat(cam_price);
                }
            }else{
                price = cam_price;
            }
            priceCalculation(user_country_id, price, extra);
        }
        
        function priceCalculation(calc_user_country_id, calc_cam_price, calc_extra_price){
            $.ajax({
                type: 'POST',
                url: '$price_calculation_url',
                data: {user_country_id: calc_user_country_id, cam_price: calc_cam_price, extra_price: calc_extra_price},
                dataType: 'json',
                success:function(data){
                    $('#price').html(data.total_price);
                    $('#processing_fee').html(data.processing_fees);
                    $('#service_tax').html(data.service_tax);
                },
                error: function(data) {
                    alert('Something went wrong. Try again');
                },
            });
        }

    });
                
    function process_startnow_form(data){
        if(data.status=="success"){
            var temp_guid = data.temp_guid;
            $("#start-now-buttons").html("Please wait <span id='clock'></span> min, while tutor will approve your booking...");
                
            var clock_html = '$clock_html';
            var end_time = data.end_time_format;
            $('#clock').countdown(end_time, function (event) {
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
                                window.location = '{$paypal_process}' + '/' + temp_guid;
                            }
                            if(data.user_before_paypal_status == "rejected"){
                                $('#startnow').modal('hide');
                                $('#reject_alert').modal('show');
//                                location.reload();
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
Yii::app()->clientScript->registerScript('_start_now', $js);
?>