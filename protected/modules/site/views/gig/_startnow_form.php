<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $booking_temp BookingTemp */
/* @var $form CActiveForm */
/* @var $tutor User */

$themeUrl = $this->themeUrl;
$tutor = $model->tutor;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-startnow-form',
    'action' => array('/site/bookingtemp/booking'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
        ));

echo $form->hiddenField($booking_temp, 'temp_gig_id', array('value' => $model->gig_id));

$session = GigBooking::gigSessionList(Yii::app()->user->id, $model->gig_id, date('Y-m-d'));
$gig_price = (int) $model->gig_price;
$extra_price = isset($model->gigExtras->extra_price) ? (int) $model->gigExtras->extra_price : 0;
$user_country_id = Yii::app()->user->country_id;
$price_calculation = GigBooking::price_calculation($user_country_id, $gig_price, $extra_price);
?>

<div class="modal fade" id="startnow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $model->gig_title; ?></h4>
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

                        <?php if (!empty($model->gigExtras)) { ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="gig-extras">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <h2> Extras </h2>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 extras-txt">
                                            <?php echo $form->checkBox($booking_temp, 'temp_book_is_extra', array('class' => 'book_extra_check', 'id' => 'temp_book_extra_inner', 'value' => 'Y', 'uncheckValue' => 'N')); ?>
                                            <?php echo $model->gigExtras->extra_description; ?>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
                                            <div id="extras-prices" class="temp_extras-prices-bg" data-temp_gig_price="<?php echo $gig_price; ?>" data-temp_extra_price="<?php echo $extra_price ?>">
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
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo CHtml::submitButton('Pay Now !', array('class' => 'btn btn-red')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$temp_sessionId = CHTML::activeId($booking_temp, 'temp_book_session');

$price_calculation_url = Yii::app()->createAbsoluteUrl('/site/gigbooking/getbookingprice');

$js = <<< EOD
    jQuery(document).ready(function ($) {
        var gig_price = $gig_price;
        var extra_price = $extra_price;
        var user_country_id = $user_country_id;
        var extra_checked = $('#temp_book_extra_inner').parent('div').hasClass('checked');
        
        $('#temp_book_extra_inner').on('ifChecked', function(event){
            gigPriceBySession($("#{$temp_sessionId}").val(), true);
        });

        $('#temp_book_extra_inner').on('ifUnchecked', function(event){
            gigPriceBySession($("#{$temp_sessionId}").val(), false);
        });
        
        // Session change Functions //
        $('#{$temp_sessionId}').on('change', function(){
            gigPriceBySession($(this).val(), $('#temp_book_extra_inner').parent('div').hasClass('checked'));
        });
        
        gigPriceBySession($("#{$temp_sessionId}").val(), extra_checked);
        
        function gigPriceBySession(session_count, is_extra){
            session = session_count;
            price = 0;
            extra = is_extra ? extra_price : 0;
        
            if(session != ''){
                for (i = 0; i < session; i++) {
                    price = parseFloat(price) + parseFloat(gig_price);
                }
            }else{
                price = gig_price;
            }
            priceCalculation(user_country_id, price, extra);
        }
        
        function priceCalculation(calc_user_country_id, calc_gig_price, calc_extra_price){
            $.ajax({
                type: 'POST',
                url: '$price_calculation_url',
                data: {user_country_id: calc_user_country_id, gig_price: calc_gig_price, extra_price: calc_extra_price},
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

EOD;
Yii::app()->clientScript->registerScript('_start_now', $js);
?>