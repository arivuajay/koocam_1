<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
        'htmlOptions' => array('role' => 'form', 'class' => ''),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'hideErrorMessage' => true,
        ),
	'enableAjaxValidation'=>true,
)); ?>\n"; ?>

            <?php echo "<?php echo \$form->errorSummary($model);" ?> ?>
            
            <?php
            $restrict = $this->giiGenerateHiddenFields();
            $activeFields = $this->giiGenerateActiveInActiveFields();

            foreach ($this->tableSchema->columns as $column) {
                if ($column->autoIncrement || in_array($column->name, $restrict))
                    continue;

                if (in_array($column->name, $activeFields)) {
                    ?>
                    <div class = "form-group checkbox checkbox-primary">
                        <?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
                        <?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
                        <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
                    </div>
                <?php } else { ?>
                    <div class = "form-group form-control-material static">
                        <?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column, array('class' => 'form-control')) . "; ?>\n";
                        ?>
                        <?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
                        <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="form-group">
                <?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save', array('class' => \$model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>\n"; ?>
            </div>

            <?php echo "<?php \$this->endWidget(); ?>\n"; ?>
        </div>
    </div>
</div>