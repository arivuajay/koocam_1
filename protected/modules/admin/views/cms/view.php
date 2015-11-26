<?php
/* @var $this CmsController */
/* @var $model Cms */

$this->title='View Cms';
$this->breadcrumbs=array(
	'Cms'=>array('index'),
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/cms/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
        'nullDisplay' => '-',
        'attributes'=>array(
//        		'cms_id',
//		'slug',
		'cms_title',
                array(
                    'name' => 'cms_description',
                    'type' => 'raw',
                ),
//		'cms_description',
		'cms_meta_keywords',
		'cms_meta_description',
		array(
                'name' => 'status',
                'type' => 'raw',
                'value' => $model->status == 1 ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
            ),
		'created_at',
        ),
        )); ?>

    </div>
</div>
