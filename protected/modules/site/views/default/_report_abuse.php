<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $abuse_model ReportAbuse */
/* @var $form CActiveForm */
/* @var $token GigTokens */

$themeUrl = $this->themeUrl;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'report-abuse-form',
    'action' => array('/site/default/reportabuse'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
        ));
echo $form->hiddenField($abuse_model, 'book_id', array('value' => $token->book->book_id));
?>
<div class="modal fade" id="abuse-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Report Abuse</h4>
            </div>
            <div class="modal-body">
                <?php echo $form->errorSummary($abuse_model); ?>

                <div class="booking-form-cont">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Do you have any comments about the about "<?php echo $token->book->gig->gig_title; ?>"?</label>
                                <?php echo $form->textArea($abuse_model, 'abuse_message', array('class' => 'form-control')); ?>
                                <?php echo $form->error($abuse_model, 'abuse_message'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo CHtml::submitButton(' Send Report', array('class' => 'btn btn-red')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>