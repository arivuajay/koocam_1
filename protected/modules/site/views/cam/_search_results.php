<?php
/* @var $this CamController */
/* @var $cam Cam */
$themeUrl = $this->themeUrl;
?>
<div id="search-results-inner-div">
    <div class="search-results-cont">
        <div class="row">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $key => $cam): ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="courses-thumb-cont">
                            <div class="course-thumbimg">
                                <?php
                                echo $cam->tutor->userstatusicon;
                                echo CHtml::link($cam->getCamthumb(array(), array('style' => 'height: 231px;')), array('/site/cam/view', 'slug' => $cam->slug));
                                ?>
                            </div>
                            <div class="course-thumbdetails">
                                <h2> <?php echo CHtml::link($cam->cam_title, array('/site/cam/view', 'slug' => $cam->slug)); ?> </h2>
                                <p> <span> <?php echo CHtml::link($cam->tutor->fullname, array('/site/user/profile', 'slug' => $cam->tutor->slug)); ?> </span> </p>
                                <div class="row">  
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">  
                                        <p>
                                            <?php
                                            $this->widget('ext.DzRaty.DzRaty', array(
                                                'name' => 'cam_rating_search' . Myclass::getRandomString(5),
                                                'value' => $cam->cam_rating,
                                                'options' => array(
                                                    'readOnly' => TRUE,
                                                    'half' => TRUE,
                                                ),
                                                'htmlOptions' => array(
                                                    'class' => 'new-half-class'
                                                ),
                                            ));
                                            ?>
                                        </p>
                                    </div> 
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <?php
                                        if (!empty($cam->tutor->languages)) {
                                            echo "<div class='languages' data-toggle='tooltip' data-placement='top' title='{$cam->tutor->languages}'> Languages </div>";
                                        }
                                        ?>
                                    </div>  
                                </div>
                            </div>
                            <div class="coures-pricedetails">
                                <div class="course-price"> <i class="fa fa-clock-o"></i> <b><?php echo $cam->cam_duration; ?></b> <span> min </span> </div>
                                <div class="course-price course-hour"> <i class="fa fa-dollar"></i> <b><?php echo (float) $cam->cam_price; ?></b> </div>
                                <div class="course-price letcame"> <?php echo CHtml::link("Let's Cam <i class='fa fa-video-camera'></i>", array('/site/cam/view', 'slug' => $cam->slug)); ?> </div>
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