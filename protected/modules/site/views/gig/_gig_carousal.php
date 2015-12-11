<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $gig Gig */
?>
<div class="scroll-cont">
    <div class="container">
        <div class="owl-carousel">
            <?php foreach ($gigs as $key => $gig): ?>
                <div class="courses-thumb-cont">
                    <div class="course-thumbimg">
                        <?php echo $gig->tutorstatusicon; ?>
                        <?php echo CHtml::link($gig->gigthumb, array('/site/gig/view', 'slug' => $gig->slug));?>
                    </div>
                    <div class="course-thumbdetails">
                        <h2><?php echo CHtml::link($gig->gig_title, array('/site/gig/view', 'slug' => $gig->slug)); ?></h2>
                        <p> <span> <?php echo CHtml::link($gig->tutor->fullname, array('/site/user/profile', 'slug' => $gig->tutor->slug)); ?> </span> </p>
                        <?php
                        $this->widget('ext.DzRaty.DzRaty', array(
                            'name' => 'gig_rating_carousal' . $key,
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
Yii::app()->clientScript->registerScript('_gig_carousal', $js);
?>
