<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->title='View Faq';
$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/faq/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
        'nullDisplay' => '-',
        'attributes'=>array(
		'question',
		'answer',
        ),
        )); ?>

    </div>
</div>
