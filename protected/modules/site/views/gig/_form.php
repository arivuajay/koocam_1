<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-create-form',
    'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => "multipart/form-data"),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
    'enableAjaxValidation' => true,
        ));
$categories = GigCategory::getCategoryList();
?>            
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sub-heading"> <?php echo $model->isNewRecord ? 'ONLY 1 STEP AND YOUR GIG IS UP :)' : $model->gig_title; ?> </div>
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 ">
        <?php echo $form->errorSummary($model); ?>
        <div class="forms-cont">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> gig information </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'gig_title'); ?>
                    <?php echo $form->textField($model, 'gig_title', array('class' => 'form-control', 'placeholder' => 'Gig Title', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Gig Title")); ?> 
                    <?php echo $form->error($model, 'gig_title'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php // echo $form->dropDownList($model, 'cat_id', $categories, array('class' => 'selectpicker', 'prompt' => '', 'data-container' => "body", 'data-trigger' => "hover", 'data-title' => "Choose Category", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Gig Category")); ?> 
                    <?php echo $form->labelEx($model, 'cat_id'); ?>
                    <?php echo $form->dropDownList($model, 'cat_id', $categories, array('class' => 'selectpicker', 'prompt' => '', 'data-title' => "Choose Category")); ?> 
                    <?php echo $form->error($model, 'cat_id'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'gig_media'); ?>
                    <span class="required">*</span>
                    <span class="btn btn-default btn-file">
                        <i class="fa fa-upload"></i>  
                        <span id="Gig_gig_media_value">Upload Video (or)  Photo (Recommended Video) </span>
                        <?php echo $form->fileField($model, 'gig_media'); ?>
                    </span>
                    <?php // echo $form->error($model, 'gig_media'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'gig_tag'); ?>
                    <?php echo $form->textField($model, 'gig_tag', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('gig_tag'), 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Tags (separate tags with commas)")); ?> 
                    <?php echo $form->error($model, 'gig_tag'); ?> 
                </div>
            </div>
            <?php if(!$model->isNewRecord){ ?>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 ">
                    <?php echo $model->getGigimage(array('style' => 'height: 150px;')); ?>
                </div>
            </div>
            <?php } ?>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                    <?php echo $form->labelEx($model, 'gig_description'); ?>
                    <?php echo $form->textArea($model, 'gig_description', array('class' => 'form-control', 'placeholder' => 'Describe your Gig', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "About your Gig")); ?> 
                    <?php echo $form->error($model, 'gig_description'); ?> 
                </div>
            </div>

            <div class="form-group"> 

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'gig_important'); ?>
                    <?php echo $form->textField($model, 'gig_important', array('class' => 'form-control', 'placeholder' => 'Important', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Important")); ?> 
                    <?php echo $form->error($model, 'gig_important'); ?> 
                </div>

                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->labelEx($model, 'gig_duration'); ?>
                    <div class="input-group" data-max="<?php echo Gig::GIG_MAX_DURATION ?>" data-min="<?php echo Gig::GIG_MIN_DURATION ?>" data-start-incr="0">
                        <span class="input-group-addon" data-incr="5">-</span>
                        <?php echo $form->textField($model, 'gig_duration', array('class' => 'form-control numberonly', 'placeholder' => 'Minutes', 'maxlength' => 2)); ?> 
                        <span class="input-group-addon" data-incr="5">+</span>
                    </div>
                    <?php echo $form->error($model, 'gig_duration'); ?> 
                </div>

                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->labelEx($model, 'gig_price'); ?>
                    <div class="input-group" data-max="<?php echo Gig::GIG_MAX_AMT ?>" data-min="<?php echo Gig::GIG_MIN_AMT ?>" data-start-incr="4">
                        <span class="input-group-addon" data-incr="1">-</span>
                        <?php echo $form->textField($model, 'gig_price', array('class' => 'form-control numberonly', 'placeholder' => 'Price')); ?> 
                        <span class="input-group-addon" data-incr="1">+</span>
                    </div>
                    <?php echo $form->error($model, 'gig_price'); ?> 
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $form->checkBox($model, 'is_extra', array('value' => 'Y', 'uncheckValue' => 'N')); ?>&nbsp;&nbsp;<?php echo $form->labelEx($model, 'is_extra', array('data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => " Are you want to add Extra Price ?")); ?>
                </div>
            </div>
            <?php
            $hide = $model->is_extra == 'N' ? 'hide' : '';
            ?>
            <div class="form-group <?php echo $hide; ?>" id="extras_div">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->labelEx($model, 'extra_price'); ?>
                    <?php echo $form->textField($model, 'extra_price', array('class' => 'form-control numberonly', 'placeholder' => 'Extra File Price', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => " Extra Price")); ?> 
                    <?php echo $form->error($model, 'extra_price'); ?> 
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'extra_description'); ?>
                    <?php echo $form->textField($model, 'extra_description', array('class' => 'form-control', 'placeholder' => 'Extra File Details', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => " About Extra File")); ?> 
                    <?php echo $form->error($model, 'extra_description'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 ">
                    <label>&nbsp;   </label>
                    <span class="btn btn-default btn-file">
                        <i class="fa fa-upload"></i>  
                        <span id="Gig_extra_file_value"> Extra File </span>
                        <?php echo $form->fileField($model, 'extra_file'); ?>
                    </span>
                    <?php // echo $form->error($model, 'extra_file'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <?php echo $form->checkBox($model, 'gig_avail_visual', array('value' => 'N', 'uncheckValue' => 'Y')); ?>&nbsp;&nbsp; <?php echo $form->labelEx($model, 'gig_avail_visual'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo CHtml::submitButton($model->isNewRecord ? ' Create Your Gig' : ' Update Your Gig', array('class' => 'btn btn-default  btn-lg explorebtn form-btn')); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
//$cs->registerScriptFile($themeUrl . '/js/mask.min.js', $cs_pos_end);
$durationId = CHTML::activeId($model, 'gig_duration');
$mediaId = CHTML::activeId($model, 'gig_media');
$extraFileId = CHTML::activeId($model, 'extra_file');
$isExtraId = CHTML::activeId($model, 'is_extra');
$priceId = CHTML::activeId($model, 'gig_price');


$price_limit_url = Yii::app()->createAbsoluteUrl('/site/gig/changepricepertime');

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#{$isExtraId}').on('ifChecked', function(event){
            $('#extras_div').removeClass('hide');
        });
        $('#{$isExtraId}').on('ifUnchecked', function(event){
            $('#extras_div').addClass('hide');
        });
//        $(".time").mask("99:99");
        
        $(".numberonly").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
               return false;
        });
        
        $(".input-group-addon").on("click", function () {
            var button = $(this);
            var input_group = button.closest('.input-group');
            var oldValue = input_group.find("input").val();
        
            if(oldValue == '')
                oldValue = input_group.data('start-incr');
        
            incr = parseFloat(button.data('incr'));
            if (button.text() == "+") {
                var newVal = parseFloat(oldValue) + incr;
        
                var max = input_group.data('max');
                if(newVal > max)
                    newVal = oldValue;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - incr;
                } else {
                    newVal = 0;
                }
        
                var min = input_group.data('min');
                if(newVal < min)
                    newVal = min;
            }
            input_group.find("input").val(newVal).trigger('change');
        });

        $('#{$durationId}').on('change', function(){
            var data=$("#gig-create-form").serialize();
            $.ajax({
                type: 'POST',
                url: '$price_limit_url',
                data:data,
                success:function(data){
                    $('#{$priceId}').val(data);
                },
                error: function(data) {
                    alert("Something went wrong. Try again");
                },
            });
        });
        
        $('#{$mediaId}').live('change', function(){ 
            $("#Gig_gig_media_value").html(this.value);
        });
        
        $('#{$extraFileId}').live('change', function(){ 
            $("#Gig_extra_file_value").html(this.value);
        });
        
    });

EOD;

Yii::app()->clientScript->registerScript('gig_form', $js);
?>