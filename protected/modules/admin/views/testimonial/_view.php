<?php
/* @var $this TestimonialController */
/* @var $data Testimonial */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonial_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->testimonial_id), array('view', 'id'=>$data->testimonial_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonial_user')); ?>:</b>
	<?php echo CHtml::encode($data->testimonial_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonial_text')); ?>:</b>
	<?php echo CHtml::encode($data->testimonial_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonial_image')); ?>:</b>
	<?php echo CHtml::encode($data->testimonial_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />


</div>