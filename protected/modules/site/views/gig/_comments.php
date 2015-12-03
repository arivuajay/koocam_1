<?php
$criteria = new CDbCriteria();
$criteria->addCondition("gig_id='$model->gig_id'");
$count = GigComments::model()->count($criteria);
$pages = new CPagination($count);

// results per page
$pages->pageSize = 10;
$pages->applyLimit($criteria);
$models = Article::model()->findAll($criteria);
?>
<h2> Comments </h2>
<div class="comments-cont">
    <div class="row">
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
            <?php echo CHtml::image($themeUrl . '/images/profile-pic.png', '', array('class' => "img-circle")); ?>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
            <p> <b> Nigs Oman </b></p>
            <p> <?php echo CHtml::image($themeUrl . '/images/rating2.jpg', '', array()); ?></p>
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur orci sit amet lacinia gravida. Suspendisse sollicitudin porta odio, nec condimentum diam viverra eu. Integer pellentesque.</p>
        </div>
    </div>
</div>