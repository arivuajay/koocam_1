<?php
/* @var $this CamController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Cams';
$this->breadcrumbs = array(
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create cam', array('/admin/cam/create'), array("class" => "btn btn-warning pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $gridColumns = array(
                    array(
                        'class' => 'IndexColumn',
                        'header' => '',
                    ),
                    array(
                        'name' => 'tutor.username',
                        'filter' => CHtml::activeTextField($model, 'tutorUserName', array('class' => 'form-control')),
                        'value' => '$data->tutor->username'
                    ),
                    'cam_title',
                    array(
                        'name' => 'cat.cat_name',
                        'filter' => CHtml::activeTextField($model, 'camCategory', array('class' => 'form-control')),
                        'value' => '$data->cat->cat_name'
                    ),
                    'cam_duration',
                    'cam_price',
//                    array(
//                        'header' => 'Status',
//                        'name' => 'status',
//                        'type' => 'raw',
//                        'value' => function($data) {
//                            echo ($data->status == 1) ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
//                        },
//                    ),
                    array(
                        'class' => 'booster.widgets.TbToggleColumn',
                        'toggleAction' => 'cam/toggle',
                        'name' => 'status',
                        'uncheckedButtonLabel' => 'In-active',
                        'checkedButtonLabel' => 'Active',
                        'afterToggle'=>'function(success,data){ if (success) alert("Status Changed successfuly"); }',
                    ),
                    array(
                        'name' => 'created_at',
                        'filter' => false
                    ),
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center', 'style' => 'width: 150px;'),
                        'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                        'afterDelete'=>'function(link,success,data){ if(data == "1") alert("This cam contains some bookings, So you can\'t delete this cam"); }'
                    )
                );

                $this->widget('application.components.MyExtendedGridView', array(
                    'filter' => $model,
                    'type' => 'striped bordered',
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    "itemsCssClass" => "table v-middle",
                    'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
            </div>
        </div>
    </div>
</div>
