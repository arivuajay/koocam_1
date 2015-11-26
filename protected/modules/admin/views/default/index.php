<?php
/* @var $this DefaultController */

$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);
?>


<div class="container-fluid">
<!--    <div class="page-section">
        <h1 class="text-display-1 margin-none">Dashboard</h1>
    </div>-->
    <div class="panel panel-default">
        <div class="media v-middle">
            <div class="media-left">
                <div class="bg-green-400 text-white">
                    <div class="panel-body">
                        <i class="fa fa-dashboard fa-fw fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="media-body">
                Welcome to <?php echo Yii::app()->name; ?>
            </div>
        </div>
    </div>
    <br/>
</div>

