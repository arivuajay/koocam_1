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
                    'order_id',
                    array(
                        'name' => 'book.cam.cam_title',
                        'value' => '$data->book->cam->cam_title'
                    ),
                    array(
                        'name' => 'booking_date',
                        'value' => function($data) {
                            echo date(PHP_SHORT_DATE_FORMAT, strtotime($data->book->book_date));
                        }
                    ),
                    array(
                        'name' => 'booking_duration',
                        'value' => '$data->book->book_duration',
                    ),
                    array(
                        'name' => 'booking_session',
                        'value' => '$data->book->book_session',
                    ),
                    array(
                        'name' => 'book.book_total_price',
                        'filter' => false,
                        'value' => '$data->book->book_total_price',
                    ),
                    array(
                        'name' => 'book.book_is_extra',
                        'value' => function($data) {
                            echo $data->book->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        }
                    ),
                    array(
                        'header' => 'Is chat opened',
                        'value' => function($data) {
                            if ($data->book->camTokens->tutor_attendance == '1' && $data->book->camTokens->learner_attendance == '1') {
                                echo '<span class="label label-info">Opened</span>';
                            } else {
                                echo '<span class="label label-warning">Not Opened</span>';
                            }
                        }
                    ),
                    array(
                        'header' => 'Receipt Status',
                        'class' => 'booster.widgets.TbButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{send}&nbsp;&nbsp;{sent}',
                        'buttons' => array(
                            'send' => array(
                                'label' => 'Click to send receipt',
                                'visible' => '$data->receipt_status == "0"',
                                'url' => 'Yii::app()->createUrl("/admin/purchase/changereceiptstatus",array("purchase_id"=>$data->purchase_id))',
                                'click' => "function(){
						if(!confirm('Are you sure?' )) return false;
                                                $('#send_button')
                                                    .removeClass('btn-danger')
                                                    .addClass('btn-warning')
                                                    .html('Processing...');
                                                $.fn.yiiGridView.update('purchase-grid', {
                                                        type:'GET',
                                                        url:$(this).attr('href'),
                                                        success:function(text,status) {
                                                            $.fn.yiiGridView.update('purchase-grid');
                                                        }
                                                });
						return false;
					}",
                                'options' => array(
                                    'title' => 'Click to send receipt',
                                    'class' => "btn btn-danger btn-flat",
                                    'id' => 'send_button'
                                ),
                            ),
                            'sent' => array(
                                'label' => '<i class="fa fa-check"></i>&nbsp;Receipt Sent',
                                'visible' => '$data->receipt_status == "1"',
                                'options' => array(
                                    'title' => 'Receipt Sent',
                                    'class' => "btn btn-success btn-flat disabled",
                                ),
                            ),
                        ),
                    ),
                    array(
                        'header' => 'Action',
                        'class' => 'booster.widgets.TbButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{view}{delete}',
                        'buttons' => array(
                            'view' => array(
                                'options' => array('class' => 'btn btn-primary btn-xs')
                            ),
                            'delete' => array(
                                'options' => array('class' => 'btn btn-danger btn-xs'),
                                'visible' => function($row_number, $data) {
                            if ($data->book->camTokens->tutor_attendance == '1' && $data->book->camTokens->learner_attendance == '1') {
                                return false;
                            }
                            return true;
                        },
                            ),
                        ),
                    )
                );

                $this->widget('application.components.MyExtendedGridView', array(
                    'id' => 'purchase-grid',
                    'filter' => $model,
                    'enableSorting' => false,
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
