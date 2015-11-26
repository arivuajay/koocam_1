<?php
/* @var $this GigController */
/* @var $model Gig */

$this->title='Update Gig';
$this->breadcrumbs=array(
	'Gigs'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/gig/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>
