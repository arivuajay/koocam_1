<?php
/* @var $this TransactionController */
/* @var $model Transaction */

$this->title='Create Transaction';
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/transaction/index'), array("class" => "btn btn-inverse pull-right"));
?>
<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>