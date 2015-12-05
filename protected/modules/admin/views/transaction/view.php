<?php
/* @var $this TransactionController */
/* @var $model Transaction */

$this->title='View Transaction';
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/transaction/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
        'nullDisplay' => '-',
        'attributes'=>array(
        		'trans_id',
		'user_id',
		'trans_type',
		'book_id',
		'trans_admin_amount',
		'trans_user_amount',
		'transaction_id',
		'trans_message',
		'paypal_address',
		'created_at',
        ),
        )); ?>

    </div>
</div>
