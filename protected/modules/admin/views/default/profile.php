<?php
$this->title = 'Edit Profile';
$this->breadcrumbs = array(
    $this->title
);
?>


<div class="container-fluid">

    <div class="page-section">
        <h1 class="text-display-1 margin-none"><?php echo $this->title; ?></h1>
    </div>

    <div class="page-section third">
        <!-- Tabbable Widget -->
        <div class="tabbable paper-shadow relative" data-z="0.5">
            <!-- Panes -->
            <div class="tab-content">
                <div id="account" class="tab-pane active">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'edit-profile-form',
                        'htmlOptions' => array(
                            'class' => 'form-horizontal',
                        ),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage'=>true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    
                    <?php echo $form->errorSummary($model); ?>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'username', array('class' => 'col-md-2 control-label')); ?>
                        <div class="col-md-6">
                            <div class="form-control-material">
                                <?php echo $form->textField($model, 'username', array('class' => 'form-control used', 'placeholder' => 'Username')); ?> 
                                <?php echo $form->labelEx($model, 'username'); ?>
                            </div>
                            <?php echo $form->error($model, 'username'); ?> 
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'email', array('class' => 'col-md-2 control-label')); ?>
                        <div class="col-md-6">
                            <div class="form-control-material">
                                <?php echo $form->textField($model, 'email', array('class' => 'form-control used', 'placeholder' => 'Email')); ?> 
                                <?php echo $form->labelEx($model, 'email'); ?>
                            </div>
                            <?php echo $form->error($model, 'email'); ?> 
                        </div>
                    </div>

                    <div class="form-group margin-none">
                        <div class="col-md-offset-2 col-md-10">
                            <?php echo CHtml::submitButton('Edit Profile', array('class' => 'btn btn-primary paper-shadow relative', 'data-z' => '0.5', 'data-hover-z' => '1', 'data-animated' => '')); ?>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <!-- // END Panes -->
        </div>
        <!-- // END Tabbable Widget -->
    </div>
</div>
