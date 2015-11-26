<?php
/* @var $this DefaultController */
/* @var $category GigCategory */

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
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="What you want to learn today ?...... ">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default search-btn" type="button"> <i class="fa fa-search"></i> </button>
                                    </span> </div>
                                <!-- /input-group --> 
                            </div>
                            <div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> <i class="fa fa-book"></i> More than 1000 courses </div>
                            <div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> <i class="fa fa-group"></i> Over 8 million students </div>
                            <div class="col-xs-9 col-sm-4 col-md-4 col-lg-4 site-feature"> <i class="fa fa-laptop"></i> Learn at your pace on any device</div>

                            <!-- /.col-lg-6 --> 
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
                    <?php echo CHtml::image($category->getFilePath(), '', array('width' => "640", 'height' => "540")); ?>
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
                    <!-- Bottom Carousel Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#quote-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#quote-carousel" data-slide-to="1"></li>
                        <li data-target="#quote-carousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Carousel Slides / Quotes -->
                    <div class="carousel-inner"> 

                        <!-- Quote 1 -->
                        <div class="item active">
                            <blockquote>
                                <div class="row">
                                    <div class="col-sm-12 text-center"> <img class="img-circle" src="<?php echo $themeUrl ?>/images/testimonails-img1.jpg" alt="" > </div>
                                    <div class="col-sm-12 testimonial-content">
                                        <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
                                        <small>Someone famous</small> </div>
                                </div>
                            </blockquote>
                        </div>
                        <!-- Quote 2 -->
                        <div class="item">
                            <blockquote>
                                <div class="row">
                                    <div class="col-sm-12 text-center"> <img class="img-circle" src="<?php echo $themeUrl ?>/images/testimonails-img1.jpg" alt="" > </div>
                                    <div class="col-sm-12 testimonial-content">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor nec lacus ut tempor. Mauris.</p>
                                        <small>Someone famous</small> </div>
                                </div>
                            </blockquote>
                        </div>
                        <!-- Quote 3 -->
                        <div class="item">
                            <blockquote>
                                <div class="row">
                                    <div class="col-sm-12 text-center"> <img class="img-circle" src="<?php echo $themeUrl ?>/images/testimonails-img1.jpg" alt="" > </div>
                                    <div class="col-sm-12 testimonial-content">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum elit in arcu blandit, eget pretium nisl accumsan. Sed ultricies commodo tortor, eu pretium mauris.</p>
                                        <small>Someone famous</small> </div>
                                </div>
                            </blockquote>
                        </div>
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
