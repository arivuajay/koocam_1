<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $cam Cam */
?>
<div class="scroll-cont">
    <div class="container">
        <div class="owl-carousel">
            <?php foreach ($cams as $key => $cam): ?>
                <div class="courses-thumb-cont">
                    <div class="course-thumbimg">
                        <?php
                        echo $cam->tutor->userstatusicon;
                        if (!empty($cam->tutor->languages)) {
                            echo "<div class='languages' data-toggle='tooltip' data-placement='top' title='{$cam->tutor->languages}'> Languages </div>";
                        }
                        echo CHtml::link($cam->camthumb, array('/site/cam/view', 'slug' => $cam->slug));
                        ?>
                    </div>
                    <div class="course-thumbdetails">
                        <h2><?php echo CHtml::link($cam->cam_title, array('/site/cam/view', 'slug' => $cam->slug)); ?></h2>
                        <p> <span> <?php echo CHtml::link($cam->tutor->fullname, array('/site/user/profile', 'slug' => $cam->tutor->slug)); ?> </span> </p>
                        <!--<p> <span> <?php echo $cam->tutor->languages ?> </span> </p>-->
                        <?php
                        $this->widget('ext.DzRaty.DzRaty', array(
                            'name' => 'cam_rating_carousal' . $key,
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
                    </div>
                    <div class="coures-pricedetails">
                        <div class="course-price"> <i class="fa fa-clock-o"></i> <b><?php echo $cam->cam_duration; ?></b> <span> min </span> </div>
                        <div class="course-price course-hour"> <i class="fa fa-dollar"></i> <b><?php echo (int) $cam->cam_price; ?></b> </div>
                        <div class="course-price letcame"> <?php echo CHtml::link("Let's Cam <i class='fa fa-video-camera'></i>", array('/site/cam/view', 'slug' => $cam->slug)); ?> </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 30,
            responsiveClass: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 4,
                }
            }
        });
    });
                
EOD;
Yii::app()->clientScript->registerScript('_cam_carousal', $js);
?>
