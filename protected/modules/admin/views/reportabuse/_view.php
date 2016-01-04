<?php
/* @var $this ReportabuseController */
/* @var $data ReportAbuse */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('abuse_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->abuse_id), array('view', 'id'=>$data->abuse_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_id')); ?>:</b>
	<?php echo CHtml::encode($data->book_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('abuse_type')); ?>:</b>
	<?php echo CHtml::encode($data->abuse_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('abuse_message')); ?>:</b>
	<?php echo CHtml::encode($data->abuse_message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('abuser_role')); ?>:</b>
	<?php echo CHtml::encode($data->abuser_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />


</div>