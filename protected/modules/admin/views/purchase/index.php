<?php
/* @var $this PurchaseController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Purchases';
$this->breadcrumbs = array(
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create purchase', array('/admin/purchase/create'), array("class" => "btn btn-warning pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $gridColumns = array(
                    array(
                        'class' => 'IndexColumn',
                        'header' => '',
                    ),
                    'book.bookUser.username',
                    array(
                        'name' => 'book.cam.cam_title',
//                        'filter' => CHtml::activeTextField((new CamBooking), 'cam', array('class' => 'form-control')),
                        'value' => '$data->book->cam->cam_title'
                    ),
                    array(
                        'name' => 'book.book_date',
                        'filter' => CHtml::activeTextField($model, 'book', array('class' => 'form-control')),
                        'value' => function($data) {
                    echo date(PHP_SHORT_DATE_FORMAT, strtotime($data->book->book_date));
                }),
//                        array(
//                            'name' => 'book.book_start_time',
//                            'value' => function($data) {
//                                echo date('H:i', strtotime($data->book->book_start_time));
//                        }),
//                        array(
//                            'name' => 'book.book_end_time',
//                            'value' => function($data) {
//                                echo date('H:i', strtotime($data->book->book_end_time));
//                        }),
                    array(
                        'name' => 'book.book_duration',
                        'filter' => CHtml::activeTextField($model, 'book', array('class' => 'form-control')),
                        'value' => '$data->book->book_duration',
                    ),
                    array(
                        'name' => 'book.book_session',
                        'filter' => CHtml::activeTextField($model, 'book', array('class' => 'form-control')),
                        'value' => '$data->book->book_session',
                    ),
                    array(
                        'name' => 'book.book_total_price',
                        'filter' => CHtml::activeTextField($model, 'book', array('class' => 'form-control')),
                        'value' => '$data->book->book_total_price',
                    ),
                    array(
                        'name' => 'book.book_is_extra',
                        'value' => function($data) {
                            echo $data->book->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
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
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{view}',
                    )
                );

                $this->widget('application.components.MyExtendedGridView', array(
                    'filter' => $model,
                    'type' => 'striped bordered',
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    "itemsCssClass" => "table v-middle",
                    'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
            </div>
        </div>
    </div>
</div>
