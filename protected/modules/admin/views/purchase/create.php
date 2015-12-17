<?php
/* @var $this PurchaseController */
/* @var $model Purchase */

$this->title='Create Purchase';
$this->breadcrumbs=array(
	'Purchases'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/purchase/index'), array("class" => "btn btn-inverse pull-right"));
?>
<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>