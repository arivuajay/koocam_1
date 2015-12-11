<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->title='Update Faq';
$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/faq/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>
