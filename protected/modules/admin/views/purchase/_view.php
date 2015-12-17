<?php
/* @var $this PurchaseController */
/* @var $data Purchase */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->purchase_id), array('view', 'id'=>$data->purchase_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_id')); ?>:</b>
	<?php echo CHtml::encode($data->book_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />


</div>