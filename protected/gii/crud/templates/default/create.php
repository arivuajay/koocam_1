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
$label = $this->pluralize($this->class2name($this->modelClass));
$classLcName = lcfirst($this->modelClass);
echo "\$this->title='Create $this->modelClass';\n";
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$this->title,
);\n";
echo "\$this->rightCornerLink = ";
?>
CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/<?php echo $classLcName; ?>/index'), array("class" => "btn btn-inverse pull-right"));
?>
<div class="container-fluid">
    <?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>\n"; ?>
</div>