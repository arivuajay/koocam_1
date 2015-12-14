<?php
/* @var $this GigController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->title = 'Page Not Found';
$themeUrl = $this->themeUrl;

?>
<div id="inner-banner" class="tt-fullHeight3 ">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">

                <h2><a href="#">404</a></h2>
                <a href="#"> Page Not Found </a><br/>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-details notfound">
                <p>  
                    <?php echo CHtml::image($themeUrl . "/images/notfound.jpg");?>
                </p>
                <p> Sorry, an error has occured, <?php echo $error['message']; ?>!  </p>
                <div class="explore-btn"> 
                    <?php echo CHtml::link('<i class="fa fa-home"></i> Take Me Home', array('/site/default/index'), array('class' => 'btn btn-default  btn-lg explorebtn')); ?>
                </div>
            </div>
        </div>
    </div>

</div>