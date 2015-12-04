<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $booking_model GigBooking */

$this->title = 'View Gig';
$this->breadcrumbs = array(
    'Gigs' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/gig/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="tabbable">
            <!-- Tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#gig" data-toggle="tab"><i class="fa fa-fw fa-wechat"></i> Gig Details</a></li>
                <li><a href="#history" data-toggle="tab"><i class="fa fa-fw fa-history"></i> Booking History</a></li>
            </ul>
            <!-- Panes -->
            <div class="tab-content">
                <div id="gig" class="tab-pane active">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
                        'nullDisplay' => '-',
                        'attributes' => array(
                            'tutor.username',
                            'gig_title',
                            'cat.cat_name',
                            array(
                                'name' => 'gig_media',
                                'type' => 'raw',
                                'value' => $model->getGigimage(array('style' => 'width: 100px; height: 100px;')),
                            ),
                            'gig_tag',
                            'gig_description',
                            'gig_duration',
                            'gig_price',
                            array(
                                'name' => 'gig_avail_visual',
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
                            'value' => '$data->bookUser->fullname'
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
//                          'book_gig_price',
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
