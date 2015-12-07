<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */

$this->title = 'Update Testimonial';
$this->breadcrumbs = array(
    'Testimonials' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/testimonial/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
