<?php
/* @var $this DefaultController */
/* @var $model Cms */

$this->title = "View - {$model->cms_title}";
$themeUrl = $this->themeUrl;
?>

<div class="tt-fullHeight3" id="inner-banner">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">

                <h2><a href="#"><?php echo $model->cms_title; ?></a></h2>
                <a href="#"> <?php echo $model->cms_tag; ?> </a><br>
            </div>
        </div>
    </div>
</div>
<?php echo $model->cms_description; ?>
