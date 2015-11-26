<?php
/* @var $this GigcategoryController */

$this->title = 'Gig Categories';
$this->breadcrumbs = array(
    $this->title
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create Gig Category', array('/admin/gigcategory/create'), array("class" => "btn btn-warning pull-right"));
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
                    'cat_name',
                    array(
                        'name' => 'cat_image',
                        'type' => 'raw',
                        'value' => function($data){
                            echo CHtml::image($data->getFilePath(), '', array('height' => 100));
                        },
                    ),
                    array(
                        'header' => 'Status',
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => function($data) {
                            echo ($data->status == 1) ? "<i class='fa fa-circle text-green-500'></i>" : "<i class='fa fa-circle text-red-500'></i>";
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
