
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cam-search-form',
    'method' => 'get',
    'action' => Yii::app()->createAbsoluteUrl('/site/cam/search'),
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>
<div class="col-lg-12">
    <div class="form-horizontal">
        <div class="input-group">
            <?php echo CHtml::textField('s', $search_text, array('class' => 'form-control', 'placeholder' => 'What you want to learn today ?...... ', 'id' => 'Cam_search_text')); ?> 
            <div class="ddl-select input-group-btn">
                <?php 
                $cat_options = CamCategory::getCategoryList('active');
                $cat_options[0] = 'All categories';
                ksort($cat_options);
                echo CHtml::dropDownList('category_id', $category_id, $cat_options, array('class' => "selectpicker form-control", 'data-style' => "btn-default"));
                ?>
            </div>
            <span class="input-group-btn">
                <?php echo CHtml::tag('button', array('class' => 'btn btn-info search-btn', 'type' => 'submit'), '<i class="fa fa-search fa-fw"></i><span>Search</span>'); ?>
            </span>
        </div>
        <div class="text-danger hide" id="search_error">Enter some text to search !!! </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> 
    <i class="fa fa-book"></i> More than 1000 cam's 
</div>
<div class="col-xs-9 col-sm-3 col-md-3 col-lg-3 site-feature"> 
    <i class="fa fa-group"></i> All over the world 
</div>
<div class="col-xs-9 col-sm-5 col-md-5 col-lg-5 site-feature"> 
    <i class="fa fa-laptop"></i> Learn everything at your pace online
</div>

<?php
$cs = Yii::app()->getClientScript();
$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#cam-search-form').submit(function(event){
//            if($('#Cam_search_text').val() == ''){
//                $('#search_error').removeClass('hide');
//                event.preventDefault();
//            }
        });
    });
                
EOD;
Yii::app()->clientScript->registerScript('_search', $js);
?>