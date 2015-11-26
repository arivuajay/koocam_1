<?php
/* @var $this GigCategoryController */
/* @var $model GigCategory */

$this->title = 'Update Gig Category';
$this->breadcrumbs = array(
    'Gig Categories' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/gigcategory/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>

