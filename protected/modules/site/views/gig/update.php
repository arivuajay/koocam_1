<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$this->title = 'Update GIG';
$this->breadcrumbs = array(
    'Gig' => array('/site/gig'),
    'Create',
);
$themeUrl = $this->themeUrl;
?>
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Update your gig </h2>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum id 
                    ultrices massa. Ut id purus lacinia enim pharetra maximus. </p>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <?php echo $this->renderPartial('_form', compact('model', 'themeUrl')); ?>
    </div>
</div>
