<?php
/* @var $this FaqController */
/* @var $data Faq */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->faq_id), array('view', 'id'=>$data->faq_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question')); ?>:</b>
	<?php echo CHtml::encode($data->question); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />


</div>