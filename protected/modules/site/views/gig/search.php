<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $gig Gig */
/* @var $form CActiveForm */
/* @var $category GigCategory */
$this->title = "Search GIG: {$search_text}";
$themeUrl = $this->themeUrl;

?>

<div id="inner-banner" class="tt-fullHeight3">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-lg-offset-2 col-md-offset-1">
            <div class="search-cont">
                <div class="search-bg">
                    <div class="row">
                        <?php $this->renderPartial('_search', compact('model', 'search_text')); ?>
                    </div>
                    <!-- /.row --> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gig-advanced-search-form',
    'htmlOptions' => array('role' => 'form', 'class' => ''),
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
    'enableAjaxValidation' => false,
        ));

echo CHtml::hiddenField('s', $search_text);
?>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                <div class="in-search-cont">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-7">
                            <h2> Search Results for "<?php echo $search_text; ?>"</h2>
                            <h4 id="itemcount">(<?php echo $pages->itemCount; ?> Results Found)</h4>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <?php
                            $sort_options = array(
                                'gig_title ASC' => 'Name (A - Z)',
                                'gig_title DESC' => 'Name (Z - A)',
                                'gig_price ASC' => 'Price (LOW > HIGH)',
                                'gig_price DESC' => 'Price (HIGH > LOW)',
                                'gig_duration ASC' => 'Minutes (LOW > HIGH)',
                                'gig_duration DESC' => 'Minutes (HIGH > LOW)',
                            );
                            echo CHtml::dropDownList('sort_by', $sort_by, $sort_options, array('class' => 'selectpicker sort_by', 'prompt' => "Sort By", 'id' => "first-disabled"));
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                            <?php
                            $page_options = array(
                                '15' => 15,
                                '25' => 25,
                                '50' => 50,
                                '75' => 75,
                                '100' => 100,
                            );
                            echo CHtml::dropDownList('page_size', $page_size, $page_options, array('class' => 'selectpicker page_size', 'prompt' => "Show", 'id' => "first-disabled"));
                            ?>
                        </div>
                    </div>
                </div>
                <div id="search_div">
                    <?php $this->renderPartial('_search_results', compact('results', 'pages')); ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 course-details">
                <div class="widget-cont">
                    <h2> Course Category </h2>
                    <div class="cate-filterlist">
                        <?php $categories = GigCategory::getCategoryList('active'); ?>
                        <ul>
                            <?php foreach ($categories as $cat_id => $cat_name): ?>
                                <li>
                                    <?php echo CHtml::checkBox('cat_id[]', in_array($cat_id, $cat_ids), array('value' => $cat_id, 'class' => 'category')) ?>
                                    <?php echo $cat_name; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="widget-cont">
                    <h2> FEATURED COURSES</h2> 
                    <?php $featured = Gig::featuredGigs(); ?>
                    <?php foreach ($featured as $gig): ?>
                        <div class="featuerd-course-cont"> 
                            <div class="row"> 
                                <div class="col-xs-4 col-sm-5 col-md-5 col-lg-5"><?php echo CHtml::link($gig->gigthumb, array('/site/gig/view', 'slug' => $gig->slug), array()); ?> </div> 
                                <div class="col-xs-8 col-sm-7 col-md-7 col-lg-7">
                                    <p> <?php echo CHtml::link($gig->gig_title, array('/site/gig/view', 'slug' => $gig->slug), array()); ?> </p>
                                    <p>  <span> <?php echo CHtml::link($gig->tutor->fullname, array('/site/user/profile', 'slug' => $gig->tutor->slug), array()); ?> </span> </p>
                                    <p>  <?php echo CHtml::image($themeUrl . '/images/rating.jpg', '', array()); ?></p>
                                </div> 
                            </div> 
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$search_url = Yii::app()->createAbsoluteUrl('/site/gig/search');

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('.selectpicker').on('change', function(){
            submit_form();
        });
        
        $('#link_pager a').each(function(){
            $(this).click(function(ev){
                ev.preventDefault();
                $.get(this.href,{ajax:true},function(html){
                    $('#search-results-inner-div').html(html);
                });
            });
        });
        
        $('.category').on('ifChecked', function(event){
            submit_form();
        });
        $('.category').on('ifUnchecked', function(event){
            submit_form();
        });
    });
        
    function submit_form(){
        var data = $("#gig-advanced-search-form").serialize();
        $.ajax({
            type: 'GET',
            url: '$search_url',
            data:data,
            dataType:'json',
            success:function(data){
                $('#itemcount').html(data.item_count);
                $('#search_div').html(data.result);
            },
            error: function(data) {
                alert("Something went wrong. Try again");
            },
        });
    }
                
EOD;
Yii::app()->clientScript->registerScript('search', $js);
?>
