<div class="scroll-cont">
    <div class="container">
        <div class="owl-carousel">
            <?php $gigs = Gig::topInstructors(); ?>
            <?php foreach ($gigs as $gig): ?>
                <div class="courses-thumb-cont">
                    <div class="course-thumbimg">
                        <div class="active-icon"> 
                            <?php echo CHtml::image($themeUrl.'/images/online.png', '', array()); ?>
                        </div>
                        <?php echo CHtml::link(CHtml::image($gig->getFilePath(false, '/users/' . $gig->tutor->user_id.'/thumb'), '', array()), array('/site/gig/view', 'slug' => $gig->slug), array()); ?>
                    </div>
                    <div class="course-thumbdetails">
                        <h2><?php echo CHtml::link($gig->gig_title, array('/site/gig/view', 'slug' => $gig->slug), array()); ?></h2>
                        <p> <span> <?php echo CHtml::link(($gig->tutor->fullname == ' ') ? $gig->tutor->username : $gig->tutor->fullname, array('/site/user/profile', 'slug' => $gig->tutor->slug), array()); ?> </span> </p>
                        <p> <?php echo CHtml::image($themeUrl . '/images/rating.jpg', '', array()); ?></p>
                    </div>
                    <div class="coures-pricedetails">
                        <div class="course-price"> <i class="fa fa-clock-o"></i> <b><?php echo $gig->gig_duration; ?></b> <span> min </span> </div>
                        <div class="course-price course-hour"> <i class="fa fa-dollar"></i> <b><?php echo (int) $gig->gig_price; ?></b> </div>
                        <div class="course-price letcame"> <a href="#"> Let's Cam <i class="fa fa-video-camera"></i></a> </div>
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
