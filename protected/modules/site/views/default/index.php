<?php
/* @var $this DefaultController */
/* @var $category GigCategory */
/* @var $form CActiveForm */

$this->title = 'Koocam - Home';
$themeUrl = $this->themeUrl;

?>

<div id="home" class="tt-fullHeight">
    <div class="container homepage-txt">
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-lg-offset-2 col-md-offset-1">
                <div class="search-cont">
                    <h2> Make your future by 
                        learning new skills</h2>
                    <div class="search-bg">
                        <div class="row">
                            <?php $this->renderPartial('/gig/_search', compact('model')); ?>
                        </div>
                        <!-- /.row --> 
                    </div>
                </div>
            </div>
            <div class="explore-btn"> <a href="#" class="btn btn-default explorebtn"> Explore Courses </a> </div>
        </div>
    </div>
</div>

<div class="home-part1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 heading-cont">
                <h2> Popular CATEGORY <br/>
                    <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </span></h2>
            </div>
            <?php
            $categories = GigCategory::popularCategory();
            $col = array(
                0 => array(
                    'xs' => 12,
                    'sm' => 4,
                    'md' => 4,
                    'lg' => 4,
                ),
                1 => array(
                    'xs' => 12,
                    'sm' => 4,
                    'md' => 4,
                    'lg' => 4,
                ),
                2 => array(
                    'xs' => 12,
                    'sm' => 4,
                    'md' => 4,
                    'lg' => 4,
                ),
                3 => array(
                    'xs' => 12,
                    'sm' => 6,
                    'md' => 6,
                    'lg' => 6,
                ),
                4 => array(
                    'xs' => 12,
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 3,
                ),
                5 => array(
                    'xs' => 12,
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 3,
                ),
            );
            foreach ($categories as $key => $category):
                ?>
                <div class="col-xs-<?php echo $col[$key]['xs'] ?> col-sm-<?php echo $col[$key]['sm'] ?> col-md-<?php echo $col[$key]['md'] ?> col-lg-<?php echo $col[$key]['lg'] ?> cate-cont">
                    <div class="cate-img">
                        <div class="cate-bg"> <a href="#"> <?php echo $category->cat_name; ?> </a> </div>
                        <?php echo CHtml::image($category->getFilePath(false, '', 'cat_image'), '', array('width' => "640", 'height' => "540")); ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="explore-btn"> <a href="#" class="btn btn-default  btn-lg explorebtn"> Browse All Categories </a> </div>
        </div>
    </div>
</div>

<!--Top Instructor -->
<div class="home-part2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 heading-cont">
                <h2> top Instructor <br>
                    <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </span></h2>
            </div>
            <?php
            $gigs = Gig::topInstructors();
            $this->renderPartial('/gig/_gig_carousal', compact('gigs', 'themeUrl'));
            ?>
        </div>
    </div>
</div>
<!--Top Instructor --> 

<!--Counts -->

<div class="counts-cont">
    <div class="container">
        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 counts-txt">
            <p> <i class="fa fa-globe"></i> </p>
            <b class="counter"> 94,532 </b><br/>
            <span> Foreign followers </span> </div>
        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 counts-txt">
            <p> <i class="fa fa-graduation-cap"></i> </p>
            <b class="counter">11,223 </b><br/>
            <span> Classes complete </span> </div>
        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 counts-txt">
            <p> <i class="fa fa-group"></i> </p>
            <b class="counter">282,673 </b><br/>
            <span> Students enrolled </span> </div>
        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 counts-txt">
            <p> <i class="fa fa-briefcase"></i></p>
            <b class="counter">745 </b><br/>
            <span> instructor </span> </div>
    </div>
</div>
<!--Counts --> 

<!--Testimonials -->
<div class="testimonials-cont tt-fullHeight2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="heading-cont heading-cont2">
                    <h2> Testimonials <br/>
                        <span> What Clients Says</span></h2>
                </div>
            </div>
            <div class="testimonials-txt">
                <div class='col-md-offset-2 col-md-8 text-center'> </div>
            </div>
            <div class='col-md-offset-1 col-md-10'>
                <div class="carousel slide" data-ride="carousel" id="quote-carousel"> 
                    <?php $testimonials = Testimonial::model()->active()->findAll(); ?>
                    <!-- Bottom Carousel Indicators -->
                    
                    <ol class="carousel-indicators">
                        <?php 
                        for($i = 0; $i <= count($testimonials) - 1; $i++){
                            $test_attr = $i == 0 ? 'class="active"' : '';
                        ?>
                        <li data-target="#quote-carousel" data-slide-to="<?php echo $i; ?>" <?php echo $test_attr; ?>></li>
                        <?php } ?>
                    </ol>

                    <!-- Carousel Slides / Quotes -->
                    <div class="carousel-inner"> 

                        <?php foreach ($testimonials as $key => $testimonial): ?>
                        <div class="item <?php echo $key == 0 ? 'active' : ''?>">
                            <blockquote>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <?php echo $testimonial->getImage(array('class' => 'img-circle')); ?>
                                    </div>
                                    <div class="col-sm-12 testimonial-content">
                                        <p><?php echo $testimonial->testimonial_text; ?></p>
                                        <small><?php echo $testimonial->testimonial_user; ?></small> </div>
                                </div>
                            </blockquote>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Testimonials --> 

<?php
$cs = Yii::app()->getClientScript();

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 1,
            time: 500
        });

        $('#quote-carousel').carousel({
            pauseOnHover: true,
            interval: 5000,
        });
    });
                
EOD;
Yii::app()->clientScript->registerScript('home', $js);
?>
