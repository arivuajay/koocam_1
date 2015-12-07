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
                                            <div id="extras-prices" class="temp_extras-prices-bg" data-temp_gig_price="<?php echo $gig_price; ?>" data-temp_extra_price="<?php echo $extra_price = (int) $model->gigExtras->extra_price; ?>">
                                                <?php echo $extra_price; ?> $
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <h4 class="temp-total-price"> Price : $ <?php echo $gig_price; ?> </h4>
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

$gig_price = $model->gig_price;
$extra_price = isset($model->gigExtras->extra_price) ? $model->gigExtras->extra_price : 0;

$js = <<< EOD
    jQuery(document).ready(function ($) {
        var gig_price = $gig_price;
        var extra_price = $extra_price;
        temp_extra_div = $('.temp_extras-prices-bg');
        
        $('#temp_book_extra_inner').on('ifChecked', function(event){
            var newPrice = parseFloat(temp_extra_div.data('temp_gig_price')) + parseFloat(temp_extra_div.data('temp_extra_price'));
            $('.temp-total-price').html('Price : $ '+newPrice);
        });

        $('#temp_book_extra_inner').on('ifUnchecked', function(event){
            var newPrice = parseFloat(temp_extra_div.data('temp_gig_price'));
            $('.temp-total-price').html('Price : $ '+newPrice);
        });
        
        // Session change Functions //
        $('#{$temp_sessionId}').on('change', function(){
            session = $(this).val();
            price = 0;
            extra = $('#temp_book_extra_inner').parent('div').hasClass('checked') ? extra_price : 0;
        
            if(session != ''){
                for (i = 0; i < session; i++) {
                    price = parseFloat(price) + parseFloat(gig_price);
                }
            }else{
                price = gig_price;
            }
        
            tot_price = parseFloat(price) + parseFloat(extra);
            $('.temp-total-price').html('Price : $ '+ tot_price);
            temp_extra_div.data('temp_gig_price', price);
        });
    });

EOD;
Yii::app()->clientScript->registerScript('_start_now', $js);
?>