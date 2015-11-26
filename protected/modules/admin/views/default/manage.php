<?php
/* @var $this DefaultController */

$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;



$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<!-- sidebar effects INSIDE of st-pusher: -->
<!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->
<!-- this is the wrapper for the content -->
<div class="st-content">
    <div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'username',
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}{update}{delete}',
            )
        );

        $export_btn = $this->renderExportGridButton('author-base-grid', '<i class="fa fa-file-excel-o"></i> Export', array('class' => 'btn btn-xs btn-danger  pull-right'));

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'id' => 'author-base-grid',
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->dataProvider(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary} &nbsp;' . $export_btn . '</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Authors</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>
</div>
<!-- /st-content -->
