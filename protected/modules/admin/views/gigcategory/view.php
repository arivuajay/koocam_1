<?php
/* @var $this GigCategoryController */
/* @var $model GigCategory */

$this->title = 'View Gig Category';
$this->breadcrumbs = array(
    'Gig Categories' => array('index'),
    $this->title
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/gigcategory/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'nullDisplay' => '-',
            'attributes' => array(
                'cat_name',
                'cat_description',
                array(
                    'label' => $model->getAttributeLabel('cat_image'),
                    'type' => 'raw',
                    'value' => CHtml::image($model->getFilePath(), '', array('height' => 200)),
                ),
                array(
                    'label' => 'Status',
                    'type' => 'raw',
                    'value' => (CHtml::encode($model->status) == 1) ? "<i class='fa fa-circle text-green-500'></i>" : "<i class='fa fa-circle text-red-500'></i>",
                ),
                'created_at',
                'modified_at',
                'created_by',
                'modified_by',
            ),
        ));
        ?>
    </div>
</div>