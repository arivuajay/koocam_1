<?php
/* @var $this PurchaseController */
/* @var $model Purchase */
/* @var $results Purchase[] */
/* @var $purchase Purchase */
/* @var $form CActiveForm */
/* @var $book GigBooking */
/* @var $gig Gig */

$this->title = 'My Jobs';
$themeUrl = $this->themeUrl;
?>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="in-search-cont">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'gig-myjobs-search-form',
                            'method' => 'GET',
                            'action' => array('/site/gigbooking/myjobs'),
                            'htmlOptions' => array('role' => 'form', 'class' => ''),
                            'clientOptions' => array(
                                'validateOnSubmit' => false,
                            ),
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        <?php
                        $options = array(
                            'all' => 'All',
                            'upcoming' => 'Upcoming',
                            'completed' => 'Completed',
                        );
                        echo CHtml::dropDownList('my_job_filter', $my_job_filter, $options, array('class' => 'selectpicker sort_by ajaxcall', 'id' => "first-disabled"));
                        ?>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="myprofile-inner">
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $key => $myjob): ?>
                <div class="purchase-cont"> 
                    <?php
                    $book = $myjob;
                    $user = $myjob->bookUser;
                    $gig = $myjob->gig;
                    ?>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 purchase-img">
                            <?php
                            $image = $gig->gigthumb;
                            echo CHtml::link($image, array('/site/gig/view', 'slug' => $gig->slug));
                            ?>                
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 purchase-gig">
                            <h2> <?php echo CHtml::link($gig->gig_title, array('/site/gig/view', 'slug' => $gig->slug)); ?></h2>
                            <p> <span> <?php echo CHtml::link($user->fullname, array('/site/user/profile', 'slug' => $user->slug)); ?> </span> </p>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 purchase-gig">
                            <p> 
                                <b> Date : </b>  
                                <?php echo date(PHP_SHORT_DATE_FORMAT, strtotime($book->book_start_time)); ?>  
                            </p>
                            <p> 
                                <b>Time : </b>  
                                <?php echo date('H:i', strtotime($book->book_start_time)) . ' - ' . date('H:i', strtotime($book->book_end_time)); ?> 
                            </p>
                            <p> <b>Sessions :</b>  <?php echo $book->book_session; ?> </p> 
                            <p> <b>Extras :</b>  <?php echo $book->book_is_extra == 'Y' ? 'Yes' : 'No'; ?> </p>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 "> 
                            <div class="purchase-price"> 
                                <h2> $ <?php echo (int) $book->book_total_price; ?> </h2>
                                <span> <i class="fa fa-clock-o"></i> <?php echo $book->book_duration; ?> min</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h4 class="text-center">No Jobs Found</h4>
        <?php endif; ?>

        <div class="pagination-cont">
            <nav>
                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    "cssFile" => false,
                    'header' => '',
                    'htmlOptions' => array('class' => 'pagination'),
                    'prevPageLabel' => '<span aria-hidden="true">«</span></a>',
                    'firstPageLabel' => '<span aria-hidden="true">« First</span></a>',
                    'nextPageLabel' => '<span aria-hidden="true">»</span>',
                    'lastPageLabel' => '<span aria-hidden="true">Last »</span>',
                    'selectedPageCssClass' => 'active',
                    'selectedPageCssClass' => 'active',
                    'maxButtonCount' => 5,
                    'id' => 'link_pager',
                ));
                ?>
            </nav>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$search_url = Yii::app()->createAbsoluteUrl('/site/gig/search');
$cs->registerCssFile($themeUrl . '/css/loader/jquery.loader.min.css');
$cs->registerScriptFile($themeUrl . '/js/loader/jquery.loader.min.js', $cs_pos_end);

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('.ajaxcall').on('change', function(){
            $("#gig-myjobs-search-form").submit();
        });

    });
EOD;
Yii::app()->clientScript->registerScript('search', $js);
?>