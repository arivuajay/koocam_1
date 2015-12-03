<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $gig_comments GigComments */
/* @var $form CActiveForm */

$this->title = "Comments";

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-comments-form',
    'action' => array('/site/gigcomments/create'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
        ));

echo $form->hiddenField($gig_comments, 'gig_id', array('value' => $model->gig_id));
?>

<div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $form->errorSummary($gig_comments); ?>

                <div class="booking-form-cont">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php
                                $this->widget('ext.DzRaty.DzRaty', array(
                                    'model' => $gig_comments,
                                    'attribute' => 'com_rating',
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php echo $form->textArea($gig_comments, 'com_comment', array('class' => 'form-control', 'placeholder' => "Enter your comments", 'class' => "form-control form-txtarea", 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Enter your comments.")); ?>
                                <?php echo $form->error($gig_comments, 'com_comment'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo CHtml::submitButton('Send', array('class' => 'btn btn-red')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>