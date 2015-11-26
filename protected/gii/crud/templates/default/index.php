<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

<?php
$label = $this->pluralize($this->class2name($this->modelClass));
$classLcName = lcfirst($this->modelClass);
echo "\$this->title='$label';\n";
echo "\$this->breadcrumbs=array(
	\$this->title,
);\n";
echo "\$this->rightCornerLink = ";
?>
CHtml::link('<i class="fa fa-plus"></i> Create <?php echo $classLcName; ?>', array('/admin/<?php echo $classLcName; ?>/create'), array("class" => "btn btn-warning pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $activeFields = $this->giiGenerateActiveInActiveFields();
                $restrict = $this->giiGenerateHiddenFields();
                ?>
                <?php echo "<?php\n"; ?>
                $gridColumns = array(
                <?php
                $count = 0;
                foreach ($this->tableSchema->columns as $column) {
                    if ($column->isPrimaryKey) {
                        echo "\t\tarray(
                                    'class' => 'IndexColumn',
                                    'header' => '',
                                ),";
                    }

                    if (in_array($column->name, $restrict))
                        continue;

                    if (++$count == 7)
                        echo "\t\t/*\n";

                    if (in_array($column->name, $activeFields)):
                        $green = '<i class="fa fa-circle text-green-500"></i>';
                        $red = '<i class="fa fa-circle text-red-500"></i>';
                        echo "\t\tarray(
                                    'header' => 'Status',
                                    'name' => '{$column->name}',
                                    'type' => 'raw',
                                    'value' => function(\$data) {
                                        echo (\$data->{$column->name} == 1) ? '{$green}' : '{$red}';
                                    },
                                ),\n";
                    else:
                        echo "\t\t'" . $column->name . "',\n";
                    endif;
                }
                if ($count >= 7)
                    echo "\t\t*/\n";
                ?>
                array(
                'header' => 'Action',
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('class' => 'text-center'),
                'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
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
