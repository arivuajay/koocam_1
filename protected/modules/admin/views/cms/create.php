<?php
/* @var $this CmsController */
/* @var $model Cms */

$this->title='Create Cms';
$this->breadcrumbs=array(
	'Cms'=>array('index'),
	$this->title,
);
?>

<div class="container-fluid">
    <div class="page-section">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="text-display-1 margin-none">
                    <?php echo $this->title; ?>
                </h1>
            </div>
            <div class="col-lg-4">
                <?php                echo CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/cms/index'), array("class" => "btn btn-inverse pull-right"));
                ?>
            </div>
        </div>
    </div>
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>