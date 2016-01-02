<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $form CActiveForm */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cam-create-form',
    'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => "multipart/form-data"),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'hideErrorMessage' => true,
    ),
    'enableAjaxValidation' => true,
        ));
$categories = CamCategory::getCategoryList();
?>            
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sub-heading"> <?php echo $model->isNewRecord ? 'ONLY 1 STEP AND YOUR CAM IS UP' : $model->cam_title; ?> </div>
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 ">
        <?php echo $form->errorSummary($model); ?>
        <div class="forms-cont">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-heading"> cam information </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'cam_title'); ?>
                    <div class="input-group"> 
                        <span class="input-group-addon withme">With me you will </span> 
                        <?php echo $form->textField($model, 'cam_title', array('class' => 'form-control', 'placeholder' => '', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Add an exciting title to your kam!")); ?>
                    </div>
                    <?php echo $form->error($model, 'cam_title'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php // echo $form->dropDownList($model, 'cat_id', $categories, array('class' => 'selectpicker', 'prompt' => '', 'data-container' => "body", 'data-trigger' => "hover", 'data-title' => "Choose Category", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Cam Category")); ?> 
                    <?php echo $form->labelEx($model, 'cat_id'); ?>
                    <?php echo $form->dropDownList($model, 'cat_id', $categories, array('class' => 'selectpicker', 'prompt' => '', 'data-title' => "Choose Category")); ?> 
                    <?php echo $form->error($model, 'cat_id'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'is_video'); ?>
                    <?php echo $form->dropDownList($model, 'is_video', array('Y' => 'Video', 'N' => 'Photo'), array('class' => 'selectpicker')); ?> 
                    <?php echo $form->error($model, 'is_video'); ?> 
                </div>
                <?php
                $url_hide = $model->is_video == 'Y' ? '' : 'hide';
                $media_hide = $model->is_video == 'N' ? '' : 'hide';
                ?>
                <div id="youtube_div" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 <?php echo $url_hide ?>">
                    <?php echo $form->labelEx($model, 'cam_youtube_url'); ?>
                    <?php echo $form->textField($model, 'cam_youtube_url', array('class' => 'form-control', 'placeholder' => 'http://www.youtube.com/watch?v=XGSy3_Czz8k', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Ex:(Video link: http://www.youtube.com/watch?v=XGSy3_Czz8k)")); ?> 
                    <?php // echo $form->error($model, 'cam_youtube_url'); ?> 
                </div>
                <div id="image_div" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 <?php echo $media_hide ?>">
                    <?php echo $form->labelEx($model, 'cam_media'); ?>
                    <span class="required">*</span>
                    <span class="btn btn-default btn-file">
                        <i class="fa fa-upload"></i>  
                        <span id="Cam_cam_media_value">Upload Photo </span>
                        <?php echo $form->fileField($model, 'cam_media'); ?>
                    </span>
                    <?php // echo $form->error($model, 'cam_media'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 ">
                    <?php echo $form->labelEx($model, 'cam_tag'); ?>
                    <?php echo $form->textField($model, 'cam_tag', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('cam_tag'), 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Tags (separate tags with commas)")); ?> 
                    <?php echo $form->error($model, 'cam_tag'); ?> 
                </div>
            </div>
            <?php if (!$model->isNewRecord) { ?>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 ">
                        <?php echo $model->getCamimage(array('style' => 'height: 150px;')); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                    <?php echo $form->labelEx($model, 'cam_description'); ?>
                    <?php echo $form->textArea($model, 'cam_description', array('class' => 'form-control', 'placeholder' => 'Describe your Cam', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "About your Cam")); ?> 
                    <?php echo $form->error($model, 'cam_description'); ?> 
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo $form->labelEx($model, 'cam_important'); ?>
                    <?php echo $form->textField($model, 'cam_important', array('class' => 'form-control', 'placeholder' => 'What the buyer must have/do for this cam Example: your cam is backing; the buyer must have 1/2 cup rice, 100-gram butter and etc.', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "What the buyer must have/do for this cam Example: your cam is backing; the buyer must have 1/2 cup rice, 100-gram butter and etc.")); ?> 
                    <?php echo $form->error($model, 'cam_important'); ?> 
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->labelEx($model, 'cam_duration'); ?>
                    <div class="input-group" data-max="<?php echo Cam::CAM_MAX_DURATION ?>" data-min="<?php echo Cam::CAM_MIN_DURATION ?>" data-start-incr="0">
                        <span class="input-group-addon minus_plus" data-incr="5">-</span>
                        <?php echo $form->textField($model, 'cam_duration', array('class' => 'form-control numberonly', 'placeholder' => 'Minutes', 'maxlength' => 2)); ?> 
                        <span class="input-group-addon minus_plus" data-incr="5">+</span>
                    </div>
                    <?php echo $form->error($model, 'cam_duration'); ?> 
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
                    <?php echo $form->labelEx($model, 'cam_price'); ?>
                    <div class="input-group" data-max="<?php echo Cam::CAM_MAX_AMT ?>" data-min="<?php echo Cam::CAM_MIN_AMT ?>" data-start-incr="4">
                        <span class="input-group-addon minus_plus" data-incr="1">-</span>
                        <?php echo $form->textField($model, 'cam_price', array('class' => 'form-control numberonly', 'placeholder' => 'Price')); ?> 
                        <span class="input-group-addon minus_plus" data-incr="1">+</span>
                    </div>
                    <?php echo $form->error($model, 'cam_price'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $form->checkBox($model, 'is_extra', array('value' => 'Y', 'uncheckValue' => 'N')); ?>&nbsp;&nbsp;<?php echo $form->labelEx($model, 'is_extra', array('data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => " Share more information with the user!")); ?>
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
                    <?php echo $form->textField($model, 'extra_description', array('class' => 'form-control', 'placeholder' => 'extra file', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Share any additional information with the user")); ?> 
                    <?php echo $form->error($model, 'extra_description'); ?> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 ">
                    <label>&nbsp;   </label>
                    <span class="btn btn-default btn-file">
                        <i class="fa fa-upload"></i>  
                        <span id="Cam_extra_file_value"> Extra File </span>
                        <?php echo $form->fileField($model, 'extra_file'); ?>
                    </span>
                    <?php // echo $form->error($model, 'extra_file'); ?> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 age-verify ">
                    <?php echo $form->radioButton($model, 'cam_avail_visual', array('value' => 'Y', 'uncheckValue' => 'N')); ?>
                    <?php echo CHtml::image($themeUrl.'/images/chat-icon.png', '', array('width' => "26", 'height' => "22")); ?> Will be available on visual chat 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 age-verify ">
                    <?php echo $form->radioButton($model, 'cam_avail_visual', array('value' => 'N', 'uncheckValue' => 'Y')); ?>
                    <?php echo CHtml::image($themeUrl.'/images/chat-icon2.png', '', array('width' => "26", 'height' => "22")); ?> Will be not available on visual chat 
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?php echo CHtml::submitButton($model->isNewRecord ? ' Create Your Cam' : ' Update Your Cam', array('class' => 'btn btn-default  btn-lg explorebtn form-btn')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$durationId = CHTML::activeId($model, 'cam_duration');
$mediaId = CHTML::activeId($model, 'cam_media');
$extraFileId = CHTML::activeId($model, 'extra_file');
$isExtraId = CHTML::activeId($model, 'is_extra');
$priceId = CHTML::activeId($model, 'cam_price');
$isVideoId = CHTML::activeId($model, 'is_video');
$price_limit_url = Yii::app()->createAbsoluteUrl('/site/cam/changepricepertime');
$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#{$isExtraId}').on('ifChecked', function(event){
            $('#extras_div').removeClass('hide');
        });
        $('#{$isExtraId}').on('ifUnchecked', function(event){
            $('#extras_div').addClass('hide');
        });
        
        $(".numberonly").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
               return false;
        });
        
        $(".minus_plus").on("click", function () {
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
        $('#{$isVideoId}').on('change', function(){
            if($(this).val() == 'Y'){
                $('#youtube_div').removeClass('hide');
                $('#image_div').addClass('hide');
            }else if($(this).val() == 'N'){
                $('#youtube_div').addClass('hide');
                $('#image_div').removeClass('hide');
            }
        });
        
        $('#{$durationId}').on('change', function(){
            var data=$("#cam-create-form").serialize();
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
        
        $('#{$mediaId}').on('change', function(){ 
            $("#Cam_cam_media_value").html(this.value);
        });
        
        $('#{$extraFileId}').on('change', function(){ 
            $("#Cam_extra_file_value").html(this.value);
        });
        
    });
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>