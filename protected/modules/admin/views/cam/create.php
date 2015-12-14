<?php
/* @var $this CamController */
/* @var $model Cam */

$this->title='Create Cam';
$this->breadcrumbs=array(
	'Cams'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/cam/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>