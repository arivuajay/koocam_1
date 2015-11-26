<?php
/* @var $this UserController */
/* @var $model User */

$this->title = 'View User';
$this->breadcrumbs = array(
    'Users' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/user/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'nullDisplay' => '-',
            'attributes' => array(
                'username',
                'email',
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'value' => $model->status == 1 ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
                ),
                'userProf.prof_firstname',
                'userProf.prof_lastname',
                'userProf.prof_tag',
                'userProf.prof_address',
                'userProf.prof_phone',
                'userProf.prof_skype',
                'userProf.prof_website',
                'userProf.prof_about',
                'created_at',
            ),
        ));
        ?>

    </div>
</div>