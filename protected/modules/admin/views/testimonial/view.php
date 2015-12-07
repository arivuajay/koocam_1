<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */

$this->title='View Testimonial';
$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/testimonial/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
        'nullDisplay' => '-',
        'attributes'=>array(
        		'testimonial_id',
		'testimonial_user',
		'testimonial_text',
		'testimonial_image',
		'created_at',
        ),
        )); ?>

    </div>
</div>
