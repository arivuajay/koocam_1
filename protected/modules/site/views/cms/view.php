<?php
/* @var $this DefaultController */
/* @var $model Cms */

$this->title = "{$model->cms_title}";
$themeUrl = $this->themeUrl;

$cover_image = '';
if(!empty($model->cover_photo)){
    $cover_image =  'background-image: url(' . $model->getFilePath() . ');';
}
?>

<div class="tt-fullHeight3" id="inner-banner" style = "<?php echo $cover_image; ?>">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">

                <h2><a href="#"><?php echo $model->cms_title; ?></a></h2>
                <a href="#"> <?php echo $model->cms_tag; ?> </a><br>
            </div>
        </div>
    </div>
</div>
<?php echo $content; ?>
