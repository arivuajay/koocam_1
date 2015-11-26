<?php
/* @var $this GigController */
/* @var $model Gig */

$this->title = 'View Gig';
$this->breadcrumbs = array(
    'Gigs' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/gig/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'nullDisplay' => '-',
            'attributes' => array(
                'tutor.username',
                'gig_title',
                'cat.cat_name',
                'gig_media',
                'gig_tag',
                'gig_description',
                'gig_duration',
                'gig_price',
                'gig_avail_visual',
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'value' => $model->status == 1 ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
                ),
                'created_at',
            ),
        ));
        ?>

    </div>
</div>
