<?php
/* @var $this ReportabuseController */
/* @var $model ReportAbuse */

$this->title='Create ReportAbuse';
$this->breadcrumbs=array(
	'Report Abuses'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/reportAbuse/index'), array("class" => "btn btn-inverse pull-right"));
?>
<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>