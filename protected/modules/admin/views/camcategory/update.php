<?php
/* @var $this CamCategoryController */
/* @var $model CamCategory */

$this->title = 'Update Cam Category';
$this->breadcrumbs = array(
    'Cam Categories' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/camcategory/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>

