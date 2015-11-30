<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $booking_model GigBooking */
/* @var $form CActiveForm */
/* @var $tutor User */
$this->title = "View - {$model->gig_title}";
$themeUrl = $this->themeUrl;
$tutor = $model->tutor;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-booking-form',
//    'action' => array('/site/gig/view', 'slug' => $model->slug),
    'action' => array('/site/gigbooking/booking'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
        ));
echo $form->hiddenField($booking_model, 'gig_id', array('value' => $model->gig_id));
echo $form->hiddenField($booking_model, 'book_date', array('value' => date('Y-m-d')));

$user_sessions = GigBooking::gigSessionPerUser(Yii::app()->user->id, $model->gig_id, date('Y-m-d'));
$session = range(1, $user_sessions);
$gig_price = (int) $model->gig_price;

$bookings = array_values(CHtml::listData(GigBooking::model()->uniqueDays()->findAll(), 'dist_date', 'dist_date'));
?>
<script type="text/javascript">
    var avail_dates = <?php echo CJSON::encode($bookings); ?>;
</script>
<div class="modal fade" id="booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $model->gig_title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $form->errorSummary($booking_model); ?>

                <div class="popup-calendaer-cont">
                    <?php
                    $event_url = Yii::app()->createAbsoluteUrl('/site/gigbooking/calendarevents');
                    $js_date_format = JS_SHORT_DATE_FORMAT;
                    $this->widget('ext.EFullCalendar.EFullCalendar', array(
                        'id' =>'booking-cal',
                        'htmlOptions' => array(
                            'style' => 'width:100%',
                            'class' => 'book-calendar'
                        ),
                        'options' => array(
                            'defaultDate' => '2015-12-01',
                            'header' => array(
                                'left' => 'prev,next today',
                                'center' => 'title',
                                'right' => 'year,month,agendaWeek,agendaDay'
                            ),
                            //uncomment if you want to show events
                            'events' => $event_url,
                            'lazyFetching' => false,
                            'dayClick' => new CJavaScriptExpression("js:function(date, allDay, jsEvent, view) {
                                var myDate = new Date();
                                var daysToAdd = -1;
                                myDate.setDate(myDate.getDate() + daysToAdd);
                                if (date < myDate) {
                                    alert('You cannot book on this day!');
                                }else{
                                    newdate = $.format.date(date, 'yyyy-MM-dd');
                                    $('#GigBooking_book_date').val(newdate);
                                    $('.book-calendar table tbody td').removeClass('fc-state-highlight');
                                    $(this).addClass('fc-state-highlight');
                                    $('#booking-cal').slideUp();
                                    $('#booking_date_txt').html($.format.date(date, '$js_date_format'));
                                }
                            }"),
                            'dayRender' => new CJavaScriptExpression('js:function (date, cell) {
                                $(cell).addClass("disabled");
//                                newdate = $.format.date(date, ""+"yyyy-MM-dd");
//                                html_cont = cell.html();
//                                console.log("ininn");
//                                if(jQuery.inArray( newdate, avail_dates ) > -1){
//                                    cell.addClass("events_highlight_new");
//                                }
                            }'),
                        )
                    ));
                    $form->error($booking_model, 'book_date');
                    ?>
                </div>
                <div class="booking-form-cont">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                Booking Date : <span id="booking_date_txt" onclick="$('#booking-cal').slideDown();"><?php echo date(PHP_SHORT_DATE_FORMAT); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                                <?php echo $form->label($booking_model, 'hours'); ?>
                                <div class="input-group" data-max="<?php echo GigBooking::HOUR_MAX ?>" data-min="<?php echo GigBooking::HOUR_MIN ?>" data-start-incr="0">
                                    <span class="input-group-addon" data-incr="1">+</span>
                                    <?php echo $form->textField($booking_model, 'hours', array('class' => 'form-control numberonly', 'placeholder' => '00', 'maxlength' => 2)); ?>
                                    <span class="input-group-addon" data-incr="1">-</span>
                                </div>
                                <?php echo $form->error($booking_model, 'hours'); ?>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                                <?php echo $form->label($booking_model, 'minutes'); ?>
                                <div class="input-group" data-max="<?php echo GigBooking::MINUTE_MAX ?>" data-min="<?php echo GigBooking::MINUTE_MIN ?>" data-start-incr="0">
                                    <span class="input-group-addon" data-incr="1">+</span>
                                    <?php echo $form->textField($booking_model, 'minutes', array('class' => 'form-control numberonly', 'placeholder' => '00', 'maxlength' => 2)); ?>
                                    <span class="input-group-addon" data-incr="1">-</span>
                                </div>
                                <?php echo $form->error($booking_model, 'minutes'); ?>
                            </div>


                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <?php echo $form->label($booking_model, 'book_session'); ?>
                                <?php echo $form->dropDownList($booking_model, 'book_session', $session, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5", 'prompt' => 'Select Session')); ?>
                                <?php echo $form->error($booking_model, 'book_session'); ?>
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
                                            <?php echo $form->checkBox($booking_model, 'book_is_extra', array('class' => 'book_extra_check', 'id' => 'book_extra_inner')); ?>
                                            <?php echo $model->gigExtras->extra_description; ?>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
                                            <div id="extras-prices" class="extras-prices-bg" data-gig_price="<?php echo $gig_price; ?>" data-extra_price="<?php echo $extra_price = (int) $model->gigExtras->extra_price; ?>">
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
                                <?php echo $form->error($booking_model, 'book_message'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <h4 class="total-price"> Price : $ <?php echo $gig_price; ?> </h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo CHtml::submitButton(' Book Now !', array('class' => 'btn btn-red')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/bootstrap-timepicker.js', $cs_pos_end);

$js = <<< EOD
    jQuery(document).ready(function ($) {

//        $('#timepicker1').on('changeTime.timepicker', function(e) {
//            $('#timeDisplay').text(e.time.value);
//        });
//
//        $('#timepicker1').timepicker({
//            minuteStep: 1,
//            showMeridian: false
//        });
//
//        setTimeout(function() {
//              $('#timeDisplay').text($('#timepicker1').val());
//        }, 100);

        $('#book_extra_inner').on('ifChecked', function(event){
            var newPrice = parseFloat(extra_div.data('gig_price')) + parseFloat(extra_div.data('extra_price'));
            $('.total-price').html('Price : $ '+newPrice);
        });

        $('#book_extra_inner').on('ifUnchecked', function(event){
            var newPrice = parseFloat(extra_div.data('gig_price'));
            $('.total-price').html('Price : $ '+newPrice);
        });

        $(".input-group-addon").on("click", function () {
            var button = $(this);
            var input_group = button.closest('.input-group');
            var oldValue = input_group.find("input").val();

            if(oldValue == '')
                oldValue = input_group.data('start-incr');

            incr = parseFloat(button.data('incr'));
            if (button.text() == "+") {
                var newVal = parseFloat(oldValue) + incr;

                var max = input_group.data('max');
                if(newVal > max)
                    newVal = oldValue;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - incr;
                } else {
                    newVal = 0;
                }

                var min = input_group.data('min');
                if(newVal < min)
                    newVal = min;
            }
            console.log(newVal);
            console.log(pad(newVal, "2"));
            input_group.find("input").val(pad(newVal, "2")).trigger('change');
        });

        $(".numberonly").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
               return false;
        });

//        $('.fc-button-today.fc-button-inner.fc-button-content').click();
        $('.fc-button-today').click();
    });

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

EOD;
Yii::app()->clientScript->registerScript('_booking_form', $js);
?>