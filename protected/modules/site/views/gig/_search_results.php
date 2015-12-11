<?php
/* @var $this GigController */
/* @var $gig Gig */
$themeUrl = $this->themeUrl;
?>
<div id="search-results-inner-div">
    <div class="search-results-cont">
        <div class="row">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $key => $gig): ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="courses-thumb-cont">
                            <div class="course-thumbimg">
                                <?php
                                echo $gig->tutorstatusicon;
                                $image = $gig->gigthumb;
                                echo CHtml::link($image, array('/site/gig/view', 'slug' => $gig->slug));
                                ?>
                            </div>
                            <div class="course-thumbdetails">
                                <h2> <?php echo CHtml::link($gig->gig_title, array('/site/gig/view', 'slug' => $gig->slug)); ?> </h2>
                                <p> <span> <?php echo CHtml::link($gig->tutor->fullname, array('/site/user/profile', 'slug' => $gig->tutor->slug)); ?> </span> </p>
                                <?php
                                $this->widget('ext.DzRaty.DzRaty', array(
                                    'name' => 'gig_rating_search' . Myclass::getRandomString(5),
                                    'value' => $gig->gig_rating,
                                    'options' => array(
                                        'readOnly' => TRUE,
                                        'half' => TRUE,
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'new-half-class'
                                    ),
                                ));
                                ?>
                            </div>
                            <div class="coures-pricedetails">
                                <div class="course-price"> <i class="fa fa-clock-o"></i> <b><?php echo $gig->gig_duration; ?></b> <span> min </span> </div>
                                <div class="course-price course-hour"> <i class="fa fa-dollar"></i> <b><?php echo (int) $gig->gig_price; ?></b> </div>
                                <div class="course-price letcame"> <?php echo CHtml::link("Let's Cam <i class='fa fa-video-camera'></i>", array('/site/gig/view', 'slug' => $gig->slug)); ?> </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No Results Found</p>
            <?php endif; ?>
        </div>
    </div>
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
<?php
$cs = Yii::app()->getClientScript();
$js = <<< EOD
    jQuery(document).ready(function ($) {
//        dzRatyUpdate();
    });
                
EOD;
Yii::app()->clientScript->registerScript('_search_results', $js);
?>