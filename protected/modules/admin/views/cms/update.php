<?php
/* @var $this CmsController */
/* @var $model Cms */

$this->title='Update Cms';
$this->breadcrumbs=array(
	'Cms'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/cms/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
