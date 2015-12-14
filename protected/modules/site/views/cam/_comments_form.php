<?php
/* @var $this DefaultController */
/* @var $model Cam */
/* @var $cam_comments CamComments */
/* @var $form CActiveForm */

if(!isset($cam_booking_id))
    $cam_booking_id = '';

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cam-comments-form',
    'action' => array('/site/camcomments/create'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
        ));

echo $form->hiddenField($cam_comments, 'cam_id', array('value' => $model->cam_id));
echo $form->hiddenField($cam_comments, 'cam_booking_id', array('value' => $cam_booking_id));
?>

<div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Comments</h4>
            </div>
            <div class="modal-body">
                <?php echo $form->errorSummary($cam_comments); ?>

                <div class="booking-form-cont">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php
                                $this->widget('ext.DzRaty.DzRaty', array(
                                    'model' => $cam_comments,
                                    'attribute' => 'com_rating',
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php echo $form->textArea($cam_comments, 'com_comment', array('class' => 'form-control', 'placeholder' => "Enter your comments", 'class' => "form-control form-txtarea", 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Enter your comments.")); ?>
                                <?php echo $form->error($cam_comments, 'com_comment'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-red')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>