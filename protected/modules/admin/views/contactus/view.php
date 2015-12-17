<?php
/* @var $this ContactusController */
/* @var $model Contactus */

$this->title='View Contactus';
$this->breadcrumbs=array(
	'Contactuses'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/contactus/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
        'nullDisplay' => '-',
        'attributes'=>array(
        		'contact_id',
		'contact_name',
		'contact_email',
		'contact_message',
		'user_id',
		'contact_category',
		'created_at',
        ),
        )); ?>

    </div>
</div>
