<?php
/* @var $this CmsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Cms';
$this->breadcrumbs = array(
    $this->title,
);
//$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create cms', array('/admin/cms/create'), array("class" => "btn btn-warning pull-right"));
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
//                    'cms_id',
//                    'slug',
                    'cms_title',
//                    array(
//                        'name' => 'cms_description',
//                        'type'=>array('type'=>'shortText','length' => 250),
//                        'htmlOptions' => array('style' => 'width: 600px;'),
//                    ),
//                    'cms_description',
                    'cms_meta_keywords',
                    'cms_meta_description',
                    array(
                        'header' => 'Status',
                        'name' => 'status',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width: 100px;'),
                        'value' => function($data) {
                            echo ($data->status == 1) ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        },
                    ),
//                      'created_at',
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
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
