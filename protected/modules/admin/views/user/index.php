<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Users';
$this->breadcrumbs = array(
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create User', array('/admin/user/create'), array("class" => "btn btn-warning pull-right"));
?>

<!-- extra div for emulating position:fixed of the menu -->
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
                    'username',
                    'email',
                    array(
                        'header' => 'Status',
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => function($data) {
                            echo ($data->status == 1) ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        },
                        'filter' => CHtml::activeDropDownList($model, 'status', array("1" => "Active", "0" => "In-Active"), array('class' => 'form-control', 'prompt' => 'All')),
                    ),
                    array(
                        'name' => 'created_at',
                        'filter' => false
                    ),
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                    )
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
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