<?php
/* @var $this ReportabuseController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Report Abuses';
$this->breadcrumbs = array(
    $this->title,
);
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
                        'header' => 'Sender',
                        'value' => function($data) {
                            echo $data->sender->username;
//                            echo CHtml::link($data->sender->username, array('/admin/user/view', 'id' => $data->sender->user_id), array('target' => '_blank'));
                        }
                    ),
                    array(
                        'header' => 'Cam',
                        'type' => 'raw',
//                    'value' => CHtml::link($model->book->cam->cam_title, array('/admin/cam/view', 'id' => $model->book->cam_id), array('target' => '_blank'))
                        'value' => '$data->book->cam->cam_title'
                    ),
                    array(
                        'name' => 'abuse_type',
                        'value' => function($data) use ($model) {
                            echo $data->abusetypes;
                        }
                    ),
                    'abuse_message',
                    array(
                        'header' => 'Abuser',
                        'value' => function($data) {
                            echo $data->abuser->username;
//                            echo CHtml::link($data->abuser->username, array('/admin/user/view', 'id' => $data->abuser->user_id), array('target' => '_blank'));
                        }
                    ),
                    'created_at',
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{view}',
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
