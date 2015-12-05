<?php
/* @var $this TransactionController */
/* @var $model Transaction */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cash-withdraw-form',
    'action' => array('/site/transaction/withdraw'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
        ));
?>
<div class="modal fade" id="withdraw-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cashout Request</h4>
            </div>
            <div class="modal-body">
                <?php echo $form->errorSummary($model); ?>

                <div class="booking-form-cont">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <?php echo $form->labelEx($model, 'paypal_address'); ?>
                                <?php echo $form->textField($model, 'paypal_address', array('class' => 'form-control', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Paypal address")); ?>
                                <?php echo $form->error($model, 'paypal_address'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <?php echo $form->labelEx($model, 'trans_user_amount'); ?>
                                <?php echo $form->textField($model, 'trans_user_amount', array('class' => 'form-control numberonly', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Withdraw Amount. Minimum ".Transaction::MIN_WITHDRAW_AMT." $")); ?>
                                <?php echo $form->error($model, 'trans_user_amount'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php echo $form->checkBox($model, 'is_message', array('value' => 'Y', 'uncheckValue' => 'N')); ?>
                                Want to send Message ?
                                <?php echo $form->error($model, 'is_message'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="message_div">
                                <?php echo $form->textArea($model, 'trans_message', array('class' => 'form-control', 'placeholder' => "Message", 'class' => "form-control form-txtarea", 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Vivamus sagittis lacus vel augue laoreet rutrum faucibus.")); ?>
                                <?php echo $form->error($model, 'trans_message'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                <?php echo CHtml::submitButton(' Send Request', array('class' => 'btn btn-red')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$messageId = CHTML::activeId($model, 'is_message');

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $(".numberonly").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
               return false;
        });
        
        // Want to send message Functions //
        $('#{$messageId}').on('ifChecked', function(event){
            $('#message_div').removeClass('hide');
        });
        $('#{$messageId}').on('ifUnchecked', function(event){
            $('#message_div').addClass('hide');
        });
    });

EOD;
Yii::app()->clientScript->registerScript('_cash_withdraw', $js);
?>