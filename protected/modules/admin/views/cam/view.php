<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $booking_model CamBooking */

$this->title = 'View Cam';
$this->breadcrumbs = array(
    'Cams' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/cam/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="tabbable">
            <!-- Tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#cam" data-toggle="tab"><i class="fa fa-fw fa-wechat"></i> Cam Details</a></li>
                <li><a href="#history" data-toggle="tab"><i class="fa fa-fw fa-history"></i> Booking History</a></li>
            </ul>
            <!-- Panes -->
            <div class="tab-content">
                <div id="cam" class="tab-pane active">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
                        'nullDisplay' => '-',
                        'attributes' => array(
                            'tutor.username',
                            'cam_title',
                            'cat.cat_name',
                            array(
                                'name' => 'cam_media',
                                'type' => 'raw',
                                'value' => $model->getCamimage(array('style' => 'width: 100px; height: 100px;')),
                            ),
                            array(
                                'name' => 'view Cam page',
                                'type' => 'raw',
                                'value' => CHtml::link('Click to Go', array('/site/cam/view', 'slug' => $model->slug), array('target' => '_blank')),
                            ),
                            'cam_tag',
                            'cam_description',
                            'cam_duration',
                            'cam_price',
                            array(
                                'name' => 'cam_avail_visual',
                                'type' => 'raw',
                                'value' => $model->status == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
                            ),
                            array(
                                'name' => 'status',
                                'type' => 'raw',
                                'value' => $model->status == 1 ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
                            ),
                            'created_at',
                        ),
                    ));
                    ?>

                </div>
                <div id="history" class="tab-pane">
                    <?php
                    $gridColumns = array(
                        array(
                            'class' => 'IndexColumn',
                            'header' => '',
                        ),
                        array(
                            'name' => 'book_user_id',
                            'value' => '$data->bookUser->username'
                        ),
//                        array(
//                            'name' => 'book_user_id',
//                            'value' => function($data) {
//                                echo $data->getUserviewlink(array('target' => '_blank'));
//                        }),
                        array(
                            'name' => 'book_date',
                            'value' => function($data) {
                                echo date(PHP_SHORT_DATE_FORMAT, strtotime($data->book_date));
                        }),
                        array(
                            'name' => 'book_start_time',
                            'value' => function($data) {
                                echo date('H:i', strtotime($data->book_start_time));
                        }),
                        array(
                            'name' => 'book_end_time',
                            'value' => function($data) {
                                echo date('H:i', strtotime($data->book_end_time));
                        }),
                        'book_session',
                        'book_total_price',
                        array(
                            'name' => 'book_is_extra',
                            'value' => function($data) {
                                echo $data->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        }),
//                          'book_cam_price',
//                          'book_extra_price',
//                          'book_message',
//                          'book_approve',
//                          'book_approved_time',
//                          'book_declined_time',
//                          'book_payment_status',
//                          'book_payment_info',
//                          'book_duration',
//                          'created_at',
                    );

                    $this->widget('application.components.MyExtendedGridView', array(
                        'filter' => $booking_model,
                        'type' => 'striped bordered',
                        'dataProvider' => $booking_model->search(),
                        'responsiveTable' => true,
                        "itemsCssClass" => "table v-middle",
                        'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>
                </div>
            </div>
            <!-- // END Panes -->
        </div>
    </div>
</div>
