<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
$classLcName = lcfirst($this->modelClass);

echo "\$this->title='View $this->modelClass';\n";
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$this->title,
);\n";
echo "\$this->rightCornerLink = ";
?>
CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/<?php echo $classLcName; ?>/index'), array("class" => "btn btn-inverse pull-right"));
?>
<?php
$restrict = $this->giiGenerateHiddenFields();
$activeFields = $this->giiGenerateActiveInActiveFields();
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
        'nullDisplay' => '-',
        'attributes'=>array(
        <?php
        foreach ($this->tableSchema->columns as $column)
            if (in_array($column->name, $activeFields)):
                $green = '<i class="fa fa-circle text-green-500"></i>';
                $red = '<i class="fa fa-circle text-red-500"></i>';
                echo "\t\tarray(
                'name' => '{$column->name}',
                'type' => 'raw',
                'value' => \$model->{$column->name} == 1 ? '{$green}' : '{$red}'
            ),\n";
            elseif (!in_array($column->name, $restrict)):
                echo "\t\t'" . $column->name . "',\n";
        endif;
        ?>
        ),
        )); ?>

    </div>
</div>
