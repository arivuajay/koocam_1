<?php
/* @var $this ReportabuseController */
/* @var $model ReportAbuse */

$this->title = 'View ReportAbuse';
$this->breadcrumbs = array(
    'Report Abuses' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/reportabuse/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'nullDisplay' => '-',
            'attributes' => array(
                array(
                    'name' => 'Sender',
                    'type' => 'raw',
                    'value' => CHtml::link($model->sender->username, array('/admin/user/view', 'id' => $model->sender->user_id), array('target' => '_blank'))
                ),
                array(
                    'name' => 'Sender Email',
                    'type' => 'raw',
                    'value' => $model->sender->email
                ),
                array(
                    'name' => 'abuse_type',
                    'value' => $model->Abusetypes
                ),
                'abuse_message',
                array(
                    'name' => 'Abuser',
                    'type' => 'raw',
                    'value' => CHtml::link($model->abuser->username, array('/admin/user/view', 'id' => $model->abuser->user_id), array('target' => '_blank'))
                ),
                array(
                    'name' => 'Abuser Email',
                    'type' => 'raw',
                    'value' => $model->abuser->email
                ),
                'created_at',
            ),
        ));
        ?>

    </div>
</div>
