<?php
/* @var $this ContactusController */
/* @var $model Contactus */

$this->title='Create Contactus';
$this->breadcrumbs=array(
	'Contactuses'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/contactus/index'), array("class" => "btn btn-inverse pull-right"));
?>
<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>