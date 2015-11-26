<?php
/* @var $this CmsController */
/* @var $data Cms */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cms_id), array('view', 'id'=>$data->cms_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_title')); ?>:</b>
	<?php echo CHtml::encode($data->cms_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_description')); ?>:</b>
	<?php echo CHtml::encode($data->cms_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_meta_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->cms_meta_keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_meta_description')); ?>:</b>
	<?php echo CHtml::encode($data->cms_meta_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	*/ ?>

</div>