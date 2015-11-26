<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-create-form',
    'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => "multipart/form-data"),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
$categories = GigCategory::getCategoryList();
?>            
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sub-heading"> <?php echo $model->isNewRecord ? 'ONLY 1 STEP AND YOUR GIG IS UP :)' : $model->gig_title; ?> </div>
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 ">
        <div class="forms-cont">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> gig information </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->textField($model, 'gig_title', array('class' => 'form-control', 'placeholder' => 'Gig Title', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Gig Title")); ?> 
                    <?php echo $form->error($model, 'gig_title'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php // echo $form->dropDownList($model, 'cat_id', $categories, array('class' => 'selectpicker', 'prompt' => '', 'data-container' => "body", 'data-trigger' => "hover", 'data-title' => "Choose Category", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Gig Category")); ?> 
                    <?php echo $form->dropDownList($model, 'cat_id', $categories, array('class' => 'selectpicker', 'prompt' => '', 'data-title' => "Choose Category")); ?> 
                    <?php echo $form->error($model, 'cat_id'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <span class="btn btn-default btn-file">
                        <i class="fa fa-upload"></i>  Upload Video (or)  Photo <span> (Recomended Video) </span>
                        <?php echo $form->fileField($model, 'gig_media'); ?>
                    </span>
                    <?php echo $form->error($model, 'gig_media'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->textField($model, 'gig_tag', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('gig_tag'), 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Tags")); ?> 
                    <?php echo $form->error($model, 'gig_tag'); ?> 
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                    <?php echo $form->textArea($model, 'gig_description', array('class' => 'form-control', 'placeholder' => 'Describe your Gig', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "About your Gig")); ?> 
                    <?php echo $form->error($model, 'gig_description'); ?> 
                </div>
            </div>

            <div class="form-group"> 

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->label($model, 'gig_important'); ?>
                    <?php echo $form->textField($model, 'gig_important', array('class' => 'form-control', 'placeholder' => 'Important', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Important")); ?> 
                    <?php echo $form->error($model, 'gig_important'); ?> 
                </div>

                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->label($model, 'gig_duration'); ?>
                    <div class="input-group" data-max="<?php echo Gig::GIG_MAX_DURATION?>" data-min="<?php echo Gig::GIG_MIN_DURATION?>" data-start-incr="0">
                        <span class="input-group-addon" data-incr="5">+</span>
                        <?php echo $form->textField($model, 'gig_duration', array('class' => 'form-control numberonly', 'placeholder' => 'Minutes', 'maxlength' => 2)); ?> 
                        <span class="input-group-addon" data-incr="5">-</span>
                    </div>
                    <?php echo $form->error($model, 'gig_duration'); ?> 
                </div>

                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->label($model, 'gig_price'); ?>
                    <div class="input-group" data-max="<?php echo Gig::GIG_MAX_AMT?>" data-min="<?php echo Gig::GIG_MIN_AMT?>" data-start-incr="4">
                        <span class="input-group-addon" data-incr="1">+</span>
                        <?php echo $form->textField($model, 'gig_price', array('class' => 'form-control numberonly', 'placeholder' => 'Price')); ?> 
                        <span class="input-group-addon" data-incr="1">-</span>
                    </div>
                    <?php echo $form->error($model, 'gig_price'); ?> 
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $form->checkBox($model, 'is_extra', array('value' => 'Y', 'uncheckValue' => 'N')); ?>&nbsp;&nbsp;<?php echo $form->labelEx($model, 'is_extra'); ?>
                </div>
            </div>
            <?php
            $hide = $model->is_extra == 'N' ? 'hide' : '';
            ?>
            <div class="form-group <?php echo $hide; ?>" id="extras_div">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->label($model, 'extra_price'); ?>
                    <?php echo $form->textField($model, 'extra_price', array('class' => 'form-control numberonly', 'placeholder' => 'Extra File Price', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => " Extra Price")); ?> 
                    <?php echo $form->error($model, 'extra_price'); ?> 
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-6 ">
                    <?php echo $form->label($model, 'extra_description'); ?>
                    <?php echo $form->textField($model, 'extra_description', array('class' => 'form-control', 'placeholder' => 'Extra File Details', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => " About Extra File")); ?> 
                    <?php echo $form->error($model, 'extra_description'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 ">
                  <label>&nbsp;   </label>
                    <span class="btn btn-default btn-file">
                        <i class="fa fa-upload"></i>  Extra File 
                        <?php echo $form->fileField($model, 'extra_file'); ?>
                    </span>
                    <?php echo $form->error($model, 'extra_file'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 ">
                    <?php echo $form->checkBox($model, 'gig_avail_visual', array('value' => 'Y', 'uncheckValue' => 'N')); ?>&nbsp;&nbsp; <?php echo $form->labelEx($model, 'gig_avail_visual'); ?>
                </div>
                <?php if ($model->isNewRecord) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 ">
                        <?php echo $form->checkBox($model, 'is_age', array('value' => 'Y', 'uncheckValue' => '')); ?>&nbsp;&nbsp; <?php echo $form->labelEx($model, 'is_age'); ?>
                        <?php echo $form->error($model, 'is_age'); ?> 
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo CHtml::submitButton($model->isNewRecord ? ' Create Your Gig' : ' Update Your Gig', array('class' => 'btn btn-default  btn-lg explorebtn form-btn')) ?>
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

$price_limit_url = Yii::app()->createAbsoluteUrl('/site/gig/changepricepertime');

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#Gig_is_extra').on('ifChecked', function(event){
            $('#extras_div').removeClass('hide');
        });
        $('#Gig_is_extra').on('ifUnchecked', function(event){
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

        $('#Gig_gig_duration').on('change', function(){
            var data=$("#gig-create-form").serialize();
            $.ajax({
                type: 'POST',
                url: '$price_limit_url',
                data:data,
                success:function(data){
                    $('#Gig_gig_price').val(data);
                },
                error: function(data) {
                    alert("Something went wrong. Try again");
                },
            });
        });
    });

EOD;

Yii::app()->clientScript->registerScript('gig_form', $js);
?>