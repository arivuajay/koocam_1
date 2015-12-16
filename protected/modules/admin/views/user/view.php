<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->title = 'View User';
$this->breadcrumbs = array(
    'Users' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/user/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> Send Message', 'javascript:void(0)', array("class" => "btn btn-info", 'data-toggle' => "modal", 'data-target' => "#modal-approve-withdraw", 'data-dismiss' => ".bs-example-modal-sm")); ?>
    <div class="page-section third">
        <div class="tabbable">
            <!-- Tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#user" data-toggle="tab"><i class="fa fa-fw fa-user"></i> User Details</a></li>
                <li><a href="#cams" data-toggle="tab"><i class="fa fa-fw fa-wechat"></i> Cams</a></li>
                <li><a href="#cam_purchase" data-toggle="tab"><i class="fa fa-fw fa-cart-plus"></i> Purchase</a></li>
                <li><a href="#cam_jobs" data-toggle="tab"><i class="fa fa-fw fa-calendar"></i> Jobs</a></li>
            </ul>
            <!-- Panes -->
            <div class="tab-content">
                <div id="user" class="tab-pane active">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
                        'nullDisplay' => '-',
                        'attributes' => array(
                            'username',
                            'email',
                            array(
                                'name' => 'Profile Picture',
                                'type' => 'raw',
                                'value' => $model->getProfilethumb(array('class' => '', 'style' => 'height: 80px;'))
                            ),
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
                <div id="cams" class="tab-pane">
                    <?php
                    $gridColumns = array(
                        array(
                            'class' => 'IndexColumn',
                            'header' => '',
                        ),
                        'cam_title',
                        array(
                            'name' => 'cat.cat_name',
                            'filter' => CHtml::activeTextField($cam_model, 'camCategory', array('class' => 'form-control')),
                            'value' => '$data->cat->cat_name'
                        ),
                        'cam_duration',
                        'cam_price',
                        array(
                            'name' => 'created_at',
                            'filter' => false
                        ),
                    );

                    $this->widget('application.components.MyExtendedGridView', array(
                        'filter' => $cam_model,
                        'type' => 'striped bordered',
                        'dataProvider' => $cam_model->search(),
                        'responsiveTable' => true,
                        "itemsCssClass" => "table v-middle",
                        'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>
                </div>
                <div id="cam_purchase" class="tab-pane">
                    <?php
                    $gridColumns = array(
                        array(
                            'class' => 'IndexColumn',
                            'header' => '',
                        ),
                        'book.cam.cam_title',
                        array(
                            'name' => 'book.book_date',
                            'value' => function($data) {
                                echo date(PHP_SHORT_DATE_FORMAT, strtotime($data->book->book_date));
                        }),
//                        array(
//                            'name' => 'book.book_start_time',
//                            'value' => function($data) {
//                                echo date('H:i', strtotime($data->book->book_start_time));
//                        }),
//                        array(
//                            'name' => 'book.book_end_time',
//                            'value' => function($data) {
//                                echo date('H:i', strtotime($data->book->book_end_time));
//                        }),
                        'book.book_duration',
                        'book.book_session',
                        'book.book_total_price',
                        array(
                            'name' => 'book.book_is_extra',
                            'value' => function($data) {
                                echo $data->book->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        }),
//                          'book_cam_price',
//                          'book_extra_price',
//                          'book_message',
//                          'book_approve',
//                          'book_approved_time',
//                          'book_declined_time',
//                          'book_payment_status',
//                          'book_payment_info',
//                          'book_duration',
//                          'created_at',
                    );

                    $this->widget('application.components.MyExtendedGridView', array(
                        'filter' => $purchase_model,
                        'type' => 'striped bordered',
                        'dataProvider' => $purchase_model->search(),
                        'responsiveTable' => true,
                        "itemsCssClass" => "table v-middle",
                        'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>
                </div>
                <div id="cam_jobs" class="tab-pane">
                    <?php
                    $gridColumns = array(
                        array(
                            'class' => 'IndexColumn',
                            'header' => '',
                        ),
                        'bookUser.username',
                        'cam.cam_title',
                        array(
                            'name' => 'book_date',
                            'value' => function($data) {
                                echo date(PHP_SHORT_DATE_FORMAT, strtotime($data->book_date));
                        }),
                        array(
                            'name' => 'book_start_time',
                            'value' => function($data) {
                                echo date('H:i', strtotime($data->book_start_time));
                        }),
                        array(
                            'name' => 'book_end_time',
                            'value' => function($data) {
                                echo date('H:i', strtotime($data->book_end_time));
                        }),
                        'book_duration',
                        'book_session',
                        'book_total_price',
                        array(
                            'name' => 'book_is_extra',
                            'value' => function($data) {
                                echo $data->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        }),
//                          'book_cam_price',
//                          'book_extra_price',
//                          'book_message',
//                          'book_approve',
//                          'book_approved_time',
//                          'book_declined_time',
//                          'book_payment_status',
//                          'book_payment_info',
//                          'book_duration',
//                          'created_at',
                    );

                    $this->widget('application.components.MyExtendedGridView', array(
                        'filter' => $job_model,
                        'type' => 'striped bordered',
                        'dataProvider' => $job_model->search(),
                        'responsiveTable' => true,
                        "itemsCssClass" => "table v-middle",
                        'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>
                </div>
            </div>
            <!-- // END Panes -->
        </div>

    </div>
</div>

<div class="modal grow modal-backdrop-white fade" id="modal-approve-withdraw">
    <div class="modal-dialog modal-large">
        <div class="v-cell">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-approve-title">Send Message to <?php echo $model->username; ?></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'message-form',
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    echo $form->hiddenField($notifn_model, 'user_id', array('value' => $model->user_id));
                    echo $form->hiddenField($notifn_model, 'notifn_type', array('value' => 'admin'));
                    ?>

                    <?php echo $form->errorSummary($notifn_model); ?>
                    <div class = "form-group form-control-material static textarea-div">
                        <?php echo $form->textArea($notifn_model, 'notifn_message', array('class' => 'form-control')); ?>
                        <?php echo $form->labelEx($notifn_model, 'notifn_message'); ?>
                        <?php echo $form->error($notifn_model, 'notifn_message'); ?>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::submitButton('Send Message', array('class' => 'btn btn-primary')); ?>
                    </div>

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
    </div>
</div>