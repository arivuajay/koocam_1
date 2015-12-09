
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-search-form',
    'method' => 'get',
    'action' => Yii::app()->createAbsoluteUrl('/site/gig/search'),
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
            <?php echo CHtml::textField('s', $search_text, array('class' => 'form-control', 'placeholder' => 'What you want to learn today ?...... ', 'id' => 'Gig_search_text')); ?> 
            <div class="ddl-select input-group-btn">
                <?php 
                $cat_options = GigCategory::getCategoryList('active');
                array_unshift($cat_options, 'All');
                echo CHtml::dropDownList('category_id', $category_id, $cat_options, array('class' => "selectpicker form-control", 'data-style' => "btn-default"));
                ?>
            </div>
            <span class="input-group-btn">
                <?php echo CHtml::tag('button', array('class' => 'btn btn-info search-btn', 'type' => 'submit'), '<i class="fa fa-search fa-fw"></i>'); ?>
            </span>
        </div>
        <div class="text-danger hide" id="search_error">Enter some text to search !!! </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> <i class="fa fa-book"></i> More than 1000 courses </div>
<div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> <i class="fa fa-group"></i> Over 8 million students </div>
<div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> <i class="fa fa-laptop"></i> Learn at your pace on any device</div>
<?php
$cs = Yii::app()->getClientScript();
$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#gig-search-form').submit(function(event){
//            if($('#Gig_search_text').val() == ''){
//                $('#search_error').removeClass('hide');
//                event.preventDefault();
//            }
        });
    });
                
EOD;
Yii::app()->clientScript->registerScript('_search', $js);
?>