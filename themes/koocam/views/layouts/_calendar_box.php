<!--<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
     <b> My Jobs </b> <span class="count">15</span>
    <span class="circle"></span>
</a>-->
<?php
//$img = CHtml::image($themeUrl . '/images/my-jobs.png', '');
//echo CHtml::link($img.'<b> My Jobs </b> <span class="count">15</span><span class="circle"></span>', '#', array('class' => '', 'data-toggle' => "modal", 'data-target' => "#booking-2")); 
?>
<!--<ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
</ul>-->

<div class="modal fade" id="booking-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $model->cam_title; ?></h4>
            </div>
            <div class="modal-body">
<?php // echo $form->errorSummary($booking_model);  ?>

                <div class="popup-calendaer-cont">
                    <?php
                    $event_url = Yii::app()->createAbsoluteUrl('/site/cambooking/usercalendarevents', array('user_id' => Yii::app()->user->id));
                    $js_date_format = JS_SHORT_DATE_FORMAT_2;
                    $user_id = Yii::app()->user->id;

                    $this->widget('ext.EFullCalendar.EFullCalendar', array(
                        'id' => 'booking-cal-2',
                        'htmlOptions' => array(
                            'style' => 'width:100%',
                            'class' => 'book-calendar'
                        ),
                        'options' => array(
                            'height' => '450',
                            'eventLimit' => true,
                            'eventLimitText' => '',
                            'views' => array(
                                'day' => array(
                                    'eventLimit' => 1
                                )
                            ),
                            'header' => array(
                                'left' => 'prev,next ',
                                'center' => 'title',
//                                'right' => 'year,month,agendaWeek,agendaDay'
                                'right' => ''
                            ),
                            //uncomment if you want to show events
                            'events' => $event_url,
                            'lazyFetching' => false,
                            'dayClick' => new CJavaScriptExpression("js:function(date, jsEvent, view) {}"),
                            'dayRender' => new CJavaScriptExpression('js:function (date, cell) {}'),
                        )
                    ));
                    ?>

                </div>
                <div class="text-left">
                    <span class="label label-primary">My Bookings</span>&nbsp;&nbsp;
                    <span class="label label-warning"><?php echo CHtml::link('My Jobs', array("/site/cambooking/myjobs"))?></span>
                </div>
            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
                        </div>-->
        </div>
    </div>
</div>
<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#booking-2').on('shown.bs.modal', function () {
            $('#booking-cal-2').trigger( 'destroy' );
            $('#booking-cal-2').fullCalendar('render');
        });
    });
EOD;
Yii::app()->clientScript->registerScript('_calendar_box', $js);
?>