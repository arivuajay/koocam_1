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
                $purchaseId = CHTML::activeId($model, 'purchase_id');
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
                                'url' => 'CHtml::normalizeUrl("#modal-send-request")',
                                'options' => array(
                                    'title' => 'Click to send receipt',
                                    'class' => "btn btn-danger btn-flat",
                                    'data-toggle' => "modal",
                                    'onclick' => "
                                        tr = $(this).closest('tr');
                                        $('#{$purchaseId}').val(tr.data('purchase_id'));
                                        $('#order_id').html(tr.data('order_id'));
                                        $('#cam_name').html(tr.data('cam_name'));
                                        $('#total_price').html(tr.data('total_price'));
                                        $('#username').html(tr.data('username'));
                                        if(tr.data('charged_status') == '0.00'){
                                            $('#charged_status').html('<span class=\"label label-danger\">17 % was not charged</span>');
                                        } else {
                                            $('#charged_status').html('<span class=\"label label-success\">17 % was charged</span>');
                                        }
                                        if(tr.data('receive_invoice_email') == '0'){
                                            $('#receive_invoice_email').html('<span class=\"label label-danger\">No</span>');
                                        } else {
                                            $('#receive_invoice_email').html('<span class=\"label label-success\">Yes</span>');
                                        }
                                        $('#company_name').html(tr.data('company_name'));
                                        $('#company_id').html(tr.data('company_id'));
                                        $('#company_address').html(tr.data('company_address'));
                                    ",
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
//                                'visible' => function($row_number, $data) {
//                            if ($data->book->camTokens->tutor_attendance == '1' && $data->book->camTokens->learner_attendance == '1') {
//                                return false;
//                            }
//                            return true;
//                        },
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
                    'columns' => $gridColumns,
                    'rowHtmlOptionsExpression' => 'array("data-purchase_id" => $data->purchase_id, "data-order_id" => $data->order_id, "data-cam_name" => $data->book->cam->cam_title, "data-total_price" => $data->book->book_total_price, "data-username" => $data->book->bookUser->username, "data-charged_status" => $data->book->book_service_tax, "data-receive_invoice_email" => $data->user->userProf->receive_invoice_email, "data-company_name" => $data->user->userProf->company_name, "data-company_id" => $data->user->userProf->company_id, "data-company_address" => $data->user->userProf->company_address)',
                        )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal grow modal-backdrop-white fade" id="modal-send-request">
    <div class="modal-dialog modal-large">
        <div class="v-cell">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="modal-approve-title">Send Receipt</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'send-request-form',
                        'action' => Yii::app()->createUrl("/admin/purchase/changereceiptstatus"),
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    echo $form->hiddenField($model, 'purchase_id');
                    ?>

                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr class="odd">
                                <th>Purchase #</th>
                                <td id="order_id"></td>
                            </tr>
                            <tr class="even">
                                <th>Cam name</th>
                                <td id="cam_name"></td>
                            </tr>
                            <tr class="odd">
                                <th>Total price paid</th>
                                <td id="total_price"></td>
                            </tr>
                            <tr class="even">
                                <th>Username</th>
                                <td id="username"></td>
                            </tr>
                            <tr class="odd">
                                <th>17% charged status</th>
                                <td id="charged_status"></td>
                            </tr>
                            <tr class="even">
                                <th>Receive invoices via email</th>
                                <td id="receive_invoice_email"></td>
                            </tr>
                            <tr class="odd">
                                <th>Company name</th>
                                <td id="company_name"></td>
                            </tr>
                            <tr class="even">
                                <th>Company id/ number</th>
                                <td id="company_id"></td>
                            </tr>
                            <tr class="odd">
                                <th>Company address</th>
                                <td id="company_address"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <?php echo CHtml::submitButton('Ok', array('class' => 'btn btn-primary')); ?>
                        <button type="button" class="btn btn-inverse" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
