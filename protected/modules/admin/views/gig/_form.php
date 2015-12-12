<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
?>

<div class="page-section third">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'gig-form',
                'htmlOptions' => array('role' => 'form', 'class' => '', 'enctype' => 'multipart/form-data'),
                'enableAjaxValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'hideErrorMessage' => true,
                ),
            ));
            ?>

            <?php echo $form->errorSummary($model); ?>

            <?php
            $tutors = User::getUsersList('active');
            $gigCategories = GigCategory::getCategoryList('active');
            $availableVisualChat = Myclass::getYesOrNo();
            $status = Myclass::getStatus();
            ?>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'tutor_id'); ?>
                <?php echo $form->dropDownList($model, 'tutor_id', $tutors, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php // echo $form->error($model, 'tutor_id'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                <?php echo $form->labelEx($model, 'gig_title'); ?>
                <?php // echo $form->error($model, 'gig_title'); ?>
            </div>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'cat_id'); ?>
                <?php echo $form->dropDownList($model, 'cat_id', $gigCategories, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php // echo $form->error($model, 'cat_id'); ?>
            </div>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'is_video'); ?>
                <?php echo $form->dropDownList($model, 'is_video', array('Y' => 'Video', 'N' => 'Photo'), array('class' => 'selectpicker')); ?> 
                <?php // echo $form->error($model, 'is_video'); ?> 
            </div>
            <?php
            $url_hide = $model->is_video == 'Y' ? '' : 'hide';
            $media_hide = $model->is_video == 'N' ? '' : 'hide';
            ?>

            <div id="image_div" class = "form-group form-control-material static <?php echo $media_hide?>">
                <?php echo $form->labelEx($model, 'gig_media'); ?>
                <?php echo $form->fileField($model, 'gig_media'); ?>
                <?php // echo $form->error($model, 'gig_media'); ?> 
            </div>

            <div id="youtube_div" class = "form-group form-control-material static <?php echo $url_hide?>">
                <?php echo $form->textField($model, 'gig_youtube_url', array('class' => 'form-control', 'placeholder' => 'Example: XGSy3_Czz8k', 'data-trigger' => "hover", 'data-container' => "body", 'data-toggle' => "popover", 'data-placement' => "bottom", 'data-content' => "Youtube Video Id. Ex:(Video link: http://www.youtube.com/watch?v=XGSy3_Czz8k) (Video Id: XGSy3_Czz8k)")); ?> 
                <?php echo $form->labelEx($model, 'gig_youtube_url'); ?>
                <?php // echo $form->error($model, 'gig_youtube_url'); ?> 
            </div>

            <div  class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_tag', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->labelEx($model, 'gig_tag'); ?>
                <?php // echo $form->error($model, 'gig_tag'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textArea($model, 'gig_description', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'gig_description'); ?>
                <?php // echo $form->error($model, 'gig_description'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_important', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->labelEx($model, 'gig_important'); ?>
                <?php echo $form->error($model, 'gig_important'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_duration', array('class' => 'form-control time numberonly')); ?>
                <?php echo $form->labelEx($model, 'gig_duration'); ?>
                <?php // echo $form->error($model, 'gig_duration'); ?>
            </div>

            <div class = "form-group form-control-material static">
                <?php echo $form->textField($model, 'gig_price', array('class' => 'form-control numberonly', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->labelEx($model, 'gig_price'); ?>
                <?php // echo $form->error($model, 'gig_price'); ?>
            </div>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'gig_avail_visual'); ?>
                <?php echo $form->dropDownList($model, 'gig_avail_visual', $availableVisualChat, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php // echo $form->error($model, 'gig_avail_visual'); ?>
            </div>

            <div class = "form-group">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', $status, array('class' => 'selectpicker', "data-style" => "btn-white", "data-size" => "5")); ?>
                <?php // echo $form->error($model, 'status'); ?>
            </div>
            <?php
            $hide = $model->is_extra == 'N' ? 'hide' : '';
            ?>
            <div class = "form-group checkbox checkbox-primary">
                <?php echo $form->checkBox($model, 'is_extra', array('value' => 'Y', 'uncheckValue' => 'N', 'class' => 'form-control')); ?>
                <?php echo $form->labelEx($model, 'is_extra'); ?>
                <?php // echo $form->error($model, 'is_extra'); ?>
            </div>

            <div class="<?php echo $hide; ?>" id="extras_div">
                <div class="form-group form-control-material static" >
                    <?php echo $form->textField($model, 'extra_price', array('class' => 'form-control numberonly')); ?>
                    <?php echo $form->labelEx($model, 'extra_price'); ?>
                    <?php // echo $form->error($model, 'extra_price'); ?> 
                </div>
                <div class="form-group form-control-material static" >
                    <?php echo $form->textField($model, 'extra_description', array('class' => 'form-control')); ?> 
                    <?php echo $form->labelEx($model, 'extra_description'); ?>
                    <?php // echo $form->error($model, 'extra_description'); ?>
                </div>

                <div class="form-group" >
                    <?php echo $form->labelEx($model, 'extra_file'); ?>
                    <?php echo $form->fileField($model, 'extra_file'); ?>
                    <?php // echo $form->error($model, 'extra_file'); ?> 
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
//$cs->registerScriptFile($themeUrl . '/js/mask.min.js', $cs_pos_end);
$durationId = CHTML::activeId($model, 'gig_duration');
$price_limit_url = Yii::app()->createAbsoluteUrl('/site/gig/changepricepertime');
$priceId = CHTML::activeId($model, 'gig_price');
$isVideoId = CHTML::activeId($model, 'is_video');

$js = <<< EOD
    jQuery(document).ready(function ($) {
//        $(".time").mask("99:99");
        
        $('#Gig_is_extra').click(function(){
            if($(this).is(":checked")){
                $("#extras_div").removeClass('hide');  // checked
            }
            else if($(this).is(":not(:checked)")){
                $("#extras_div").addClass('hide');  // unchecked
            }
        });
        
        $(".numberonly").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
               return false;
        });
        
        $("#{$durationId}").keypress(function (e) {
            priceLimit();
        });
        
        $('#{$durationId}').on('change', function(){
            priceLimit();
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
    });
        
    function priceLimit(){
        var data=$("#gig-form").serialize();
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
    }

EOD;

Yii::app()->clientScript->registerScript('gig_create', $js);
?>