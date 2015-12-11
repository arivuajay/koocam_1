<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'message-form',
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));

echo $form->hiddenField($model, 'user2', array("value" => $userto_id));
echo $form->hiddenField($model, 'id2', array("value" => count($mymessages) + 1));
?>
<div class="replybox-cont">
    <div class="form-group">
        <?php // echo $form->labelEx($model, 'message'); ?>
        <?php echo $form->textArea($model, 'message', array('class' => 'form-control form-txtarea allow_foriegn', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50, 'placeholder' => 'Tell About Something......')); ?> 
        <?php echo $form->error($model, 'message'); ?>
    </div>
    <div class="">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'btn btn-default  btn-lg explorebtn form-btn'
                        ), 'Send');
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>