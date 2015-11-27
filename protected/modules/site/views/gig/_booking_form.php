<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $booking_model GigBooking */
/* @var $form CActiveForm */
/* @var $tutor User */
$this->title = "View - {$model->gig_title}";
$themeUrl = $this->themeUrl;
$tutor = $model->tutor;
?>
<div class="modal fade" id="booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Do You speak english?</h4>
            </div>
            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'gig-booking-form',
                    'htmlOptions' => array('role' => 'form', 'class' => ''),
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'hideErrorMessage' => true,
                    ),
                ));
                $user_sessions = GigBooking::gigSessionPerUser(Yii::app()->user->id, $model->gig_id, date('Y-m-d'));
                $session = range(1, $user_sessions);
                $gig_price = (int)$model->gig_price;
                ?>
                <?php echo $form->errorSummary($booking_model); ?>

                <div class="popup-calendaer-cont"> <img src="images/calendar.jpg"  alt=""></div>
                <div class="booking-form-cont">
                    <div class="row"> 
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <?php echo $form->textField($booking_model, 'book_start_time', array('class' => 'form-control', 'id' => "timepicker1", 'class' => "form-control input-small")); ?>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <?php echo $form->error($booking_model, 'book_start_time'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <?php echo $form->dropDownList($booking_model, 'book_session', $session, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5", 'data=title' => 'Choose Session')); ?>
                            </div>
                        </div>
                        <?php if(!empty($model->gigExtras)){ ?>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                                <div class="gig-extras">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                            <h2> Extras </h2>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 extras-txt">  
                                        <?php echo $form->checkBox($booking_model, 'book_is_extra', array()); ?>
                                            <?php echo $model->gigExtras->extra_description; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 "> 
                                        <div class="extras-prices-bg" data-gig_price="<?php echo $gig_price; ?>" data-extra_price="<?php echo $extra_price = (int)$model->gigExtras->extra_price; ?>">
                                            <?php echo $extra_price; ?> $
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                                <?php echo $form->textArea($booking_model, 'book_message', array('class' => 'form-control', 'placeholder' => "Message", 'class' => "form-control form-txtarea", 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Vivamus sagittis lacus vel augue laoreet rutrum faucibus.")); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <h4 class="total-price" data-total_price="<?php echo $gig_price; ?>"> Price : $ <?php echo $gig_price; ?> </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-red">Book Now ! </button>
            </div>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/bootstrap-timepicker.js', $cs_pos_end);

$js = <<< EOD
    jQuery(document).ready(function ($) {
        
        $('#timepicker1').on('changeTime.timepicker', function(e) {
            $('#timeDisplay').text(e.time.value);
        });
    
        $('#timepicker1').timepicker({
            minuteStep: 1,
            showMeridian: false
        });
        
        setTimeout(function() {
              $('#timeDisplay').text($('#timepicker1').val());
        }, 100);
        
        $('#GigBooking_book_is_extra').is(":checked"){
            extra_div = $('.extras-prices-bg');
            newPrice = extra_div.data('gig_price') + extra_div.data('extra_price');
            console.log(newPrice);
        });

    });
EOD;
Yii::app()->clientScript->registerScript('_booking_form', $js);
?>