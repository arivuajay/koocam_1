<?php
/* @var $this ContactusController */
/* @var $model Contactus */
/* @var $new_model Contactus */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Contact Messages';
$this->breadcrumbs = array(
    $this->title,
);
$this->rightCornerLink = '';
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $contId = CHTML::activeId($model, 'contact_id');
                
                $gridColumns = array(
                    array(
                        'class' => 'IndexColumn',
                        'header' => '',
                    ),
                    array(
                        'name' => 'contact_name',
                        'type' => 'raw',
                        'value' => function($data){
                            if(!empty($data->user_id)){
                                echo $data->user->username;
                            }else{
                                echo $data->contact_name;
                            }
                        },
                    ),
                    'contact_email',
                    'contact_message',
                    array(
                        'name' => 'category',
                        'type' => 'raw',
                        'value' => '$data->category',
                        'filter' => CHtml::activeDropDownList($model, 'contact_category', $model->getCategoryList(), array('class' => 'form-control', 'prompt' => 'All')),
                    ),
                    array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => '$data->currentstatus',
                        'filter' => CHtml::activeDropDownList($model, 'status', $model->getCurrentstatuslist(), array('class' => 'form-control', 'prompt' => 'All')),
                    ),
                    'created_at',
                    'contact_reply',
                    array(
                        'header' => 'Action',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('class' => 'text-center'),
                        'template' => '{reply}&nbsp;&nbsp;{replied}&nbsp;&nbsp;',
                        'buttons' => array(
                            'reply' => array(
                                'label' => 'Reply',
                                'options' => array(
                                    'title' => 'Privilages',
                                    'data-toggle' => "modal",
                                    'class' => "btn btn-warning btn-flat",
                                    'onclick' => "
                                        tr = $(this).closest('tr');
                                        $('#{$contId}').val(tr.data('contact_id'));
                                        $('#user-name').val(tr.data('username'));
                                        $('#user-message').val(tr.data('message'));
                                        $('#user-email').val(tr.data('email'));
                                    ",
                                ),
                                'url' => 'CHtml::normalizeUrl("#modal-approve-withdraw")',
                                'visible' => '$data->status == "0"'
                            ),
                            'replied' => array(
                                'label' => 'Completed',
                                'options' => array(
                                    'title' => 'Privilages',
                                    'data-toggle' => "modal",
                                    'class' => "btn btn-success btn-flat disabled",
                                ),
                                'visible' => '$data->status == "1"'
                            ),
                        )
                    )
                );

                $this->widget('application.components.MyExtendedGridView', array(
                    'filter' => $model,
                    'type' => 'striped bordered',
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    "itemsCssClass" => "table v-middle",
                    'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                    'columns' => $gridColumns,
                    'rowHtmlOptionsExpression' => 'array("data-contact_id" => $data->contact_id, "data-username" => $data->contact_name, "data-message" => $data->contact_message, "data-email" => $data->contact_email)',
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal grow modal-backdrop-white fade" id="modal-approve-withdraw">
    <div class="modal-dialog modal-large">
        <div class="v-cell">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-approve-title">Reply</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'contact-form',
                        'htmlOptions' => array('role' => 'form', 'class' => ''),
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'hideErrorMessage' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    echo $form->hiddenField($new_model, 'contact_id');
                    echo $form->hiddenField($new_model, 'status', array('value' => '1'));
                    ?>

                    <?php echo $form->errorSummary($new_model); ?>
                    <div class = "form-group form-control-material static">
                        <input type="text" class="form-control" id="user-name" disabled="true" value="">
                        <label for="user-name"><?php echo $new_model->getAttributeLabel('contact_name'); ?></label>
                    </div>
                    
                    <div class = "form-group form-control-material static">
                        <input type="text" class="form-control" id="user-email" disabled="true" value="">
                        <label for="user-email"><?php echo $new_model->getAttributeLabel('contact_email'); ?></label>
                    </div>
                    
                    <div class = "form-group form-control-material static textarea-div">
                        <textarea class="form-control" id="user-message" disabled="true" value=""></textarea>
                        <label for="user-message"><?php echo $new_model->getAttributeLabel('contact_message'); ?></label>
                    </div>
                    
                    <div class = "form-group form-control-material static textarea-div">
                        <?php echo $form->textArea($new_model, 'contact_reply', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->labelEx($new_model, 'contact_reply'); ?>
                        <?php echo $form->error($new_model, 'contact_reply'); ?>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::submitButton('Send', array('class' => 'btn btn-primary')); ?>
                    </div>

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
    </div>
</div>