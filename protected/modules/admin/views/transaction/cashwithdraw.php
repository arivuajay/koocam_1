<?php
/* @var $this TransactionController */
/* @var $model Transaction */
/* @var $form CActiveForm */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Cash Withdraw';
$this->breadcrumbs = array(
    $this->title,
);
//$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create transaction', array('/admin/transaction/create'), array("class" => "btn btn-warning pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $transId = CHTML::activeId($model, 'trans_id');
                $statusId = CHTML::activeId($model, 'status');

                $gridColumns = array(
                    array(
                        'class' => 'IndexColumn',
                        'header' => '',
                    ),
                    array(
                        'name' => 'user_id',
                        'value' => '$data->user->username',
                    ),
                    'trans_user_amount',
                    'paypal_address',
                    'trans_message',
                    array(
                        'header' => 'Request Sent On',
                        'value' => '$data->created_at'
                    ),
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{approve}&nbsp;&nbsp;{reject}&nbsp;&nbsp;{approved}&nbsp;&nbsp;{rejected}',
                        'buttons' => array(
                            'approve' => array(
                                'label' => 'Approve',
                                'options' => array(
                                    'title' => 'Approve',
                                    'data-toggle' => "modal",
                                    'class' => "btn btn-success btn-flat",
                                    'onclick' => "
                                        tr = $(this).closest('tr');
                                        $('#{$transId}').val(tr.data('trans_id'));
                                        $('#{$statusId}').val('1');
                                        $('#trans_div').removeClass('hide');
                                        
                                        $('#user-name').val(tr.data('username'));
                                        $('#draw-amount').val(tr.data('amt'));
                                        $('#paypal-address').val(tr.data('paypal'));
                                        $('#modal-approve-title').html('Approve Request');
                                    ",
                                ),
                                'url' => 'CHtml::normalizeUrl("#modal-approve-withdraw")',
                                'visible' => '$data->status == "0"'
                            ),
                            'reject' => array(
                                'label' => 'Reject',
                                'options' => array(
                                    'title' => 'Reject',
                                    'data-toggle' => "modal",
                                    'class' => "btn btn-danger btn-flat",
                                    'onclick' => "
                                        tr = $(this).closest('tr');
                                        $('#{$transId}').val(tr.data('trans_id'));
                                        $('#{$statusId}').val('2');
                                        $('#trans_div').addClass('hide');
                                        
                                        $('#user-name').val(tr.data('username'));
                                        $('#draw-amount').val(tr.data('amt'));
                                        $('#paypal-address').val(tr.data('paypal'));
                                        $('#modal-approve-title').html('Reject Request');
                                    ",
                                ),
                                'url' => 'CHtml::normalizeUrl("#modal-approve-withdraw")',
                                'visible' => '$data->status == "0"'
                            ),
                            'approved' => array(
                                'label' => '<i class="fa fa-check"></i>&nbsp;Approved',
                                'options' => array(
                                    'title' => 'Approved',
                                    'data-toggle' => "modal",
                                    'class' => "btn btn-white btn-flat disabled",
                                ),
                                'visible' => '$data->status == "1"'
                            ),
                            'rejected' => array(
                                'label' => '<i class="fa fa-close"></i>&nbsp;&nbsp;Rejected',
                                'options' => array(
                                    'title' => 'Rejected',
                                    'data-toggle' => "modal",
                                    'class' => "btn btn-white btn-flat disabled",
                                ),
                                'visible' => '$data->status == "2"'
                            ),
                        ),
                    ),
                );

                $this->widget('application.components.MyExtendedGridView', array(
                    'filter' => $model,
                    'type' => 'striped bordered',
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    "itemsCssClass" => "table v-middle",
                    'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                    'columns' => $gridColumns,
                    'rowHtmlOptionsExpression' => 'array("data-trans_id" => $data->trans_id, "data-username" => $data->user->username, "data-amt" => $data->trans_user_amount, "data-paypal" => $data->paypal_address)',
                        )
                );
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal grow modal-backdrop-white fade" id="modal-approve-withdraw">
    <div class="modal-dialog modal-large">
        <div class="v-cell">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-approve-title">Cash Withdraw Reply</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'transaction-form',
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    echo $form->hiddenField($model, 'trans_id');
                    echo $form->hiddenField($model, 'status');
                    ?>

                    <?php echo $form->errorSummary($model); ?>
                    <div class = "form-group form-control-material static">
                        <input type="text" class="form-control" id="user-name" disabled="true" value="">
                        <label for="user-name"><?php echo $model->getAttributeLabel('user_id'); ?></label>
                    </div>
                    
                    <div class = "form-group form-control-material static">
                        <input type="text" class="form-control" id="draw-amount" disabled="true" value="">
                        <label for="draw-amount"><?php echo $model->getAttributeLabel('trans_user_amount'); ?></label>
                    </div>
                    
                    <div class = "form-group form-control-material static">
                        <input type="text" class="form-control" id="paypal-address" disabled="true" value="">
                        <label for="paypal-address"><?php echo $model->getAttributeLabel('paypal_address'); ?></label>
                    </div>
                    
                    <div class = "form-group form-control-material static" id="trans_div">
                        <?php echo $form->textField($model, 'transaction_id', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->labelEx($model, 'transaction_id'); ?>
                        <?php echo $form->error($model, 'transaction_id'); ?>
                    </div>
                    <div class = "form-group form-control-material static textarea-div">
                        <?php echo $form->textArea($model, 'trans_reply', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->labelEx($model, 'trans_reply'); ?>
                        <?php echo $form->error($model, 'trans_reply'); ?>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
                    </div>

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
    </div>
</div>