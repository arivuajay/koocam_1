<?php
/* @var $this UserController */
/* @var $model User */

$this->title = 'Create User';
$this->breadcrumbs = array(
    'Users' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/user/index'), array("class" => "btn btn-inverse pull-right"));
?>

<div class="container-fluid">
    <?php $this->renderPartial('_form', array('model' => $model, 'userProfile' => $userProfile)); ?>
</div>
