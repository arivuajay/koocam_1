<?php
/* @var $this DefaultController */
/* @var $model User */
/* @var $category GigCategory */

$this->title = 'Koocam - Profile';
$themeUrl = $this->themeUrl;
?>

<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">
                <h2> 
                    <?php echo CHtml::link($model->fullname, array('/site/user/profile', 'slug' => $model->slug)); ?> 
                    <?php if (!Yii::app()->user->isGuest) { ?>
                        <button class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-sm2" data-dismiss=".bs-example-modal-sm2"> <i class="fa fa-pencil"></i> </button>
                    <?php } ?>

                </h2>
                <?php echo CHtml::link($user_profile->prof_tag, '#'); ?>
                <br/>
                <?php echo CHtml::image($themeUrl . '/images/ratings.png', ''); ?>
            </div>
        </div>
    </div>
</div>

<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="course-img">
                    <div class="online" data-toggle="tooltip" data-placement="bottom" title="online"> </div>
                    <?php echo CHtml::image($user_profile->getFilePath(false, '/users/' . $model->user_id), '', array()); ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="#" class="big-btn btn  btn-default "> <i class="fa fa-envelope-o"></i> Message </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sharethis-share">
                        <span class='st_facebook_large custom-share' displayText='Facebook'></span>
                        <span class='st_twitter_large custom-share' displayText='Tweet'></span>
                        <span class='st_googleplus_large custom-share' displayText='Google +'></span>
                        <span class='st_sharethis_large custom-share' displayText='ShareThis'></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 course-details">

                <h2> About <?php echo $model->fullname; ?> </h2>

                <p class="date"> Date of Join : <?php echo date(PHP_SHORT_DATE_FORMAT, strtotime($model->created_at)); ?></p>
                <p><?php echo $user_profile->prof_about; ?></p>

                <h4> Country </h4>
                <p> <?php echo $model->country; ?> </p>

                <h4> Languages </h4>
                <p> <?php echo $model->languages ?> </p>

                <h4> Interests </h4>
                <p> <?php echo $user_profile->prof_interests; ?></p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comentslist-cont relateditems">
                <h2> Reflection  Peter Parker Sells</h2>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php
            $gigs = Gig::topInstructors();
            $this->renderPartial('/gig/_gig_carousal', compact('gigs', 'themeUrl'));
            ?>
        </div>
    </div>
</div>

<?php
if (!Yii::app()->user->isGuest) {
    $this->renderPartial('_profile_edit', compact('model', 'user_profile'));
}
?>

<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "b111ba58-0a07-447e-92ed-da6eda1af9b3", doNotHash: false, doNotCopy: false, hashAddressBar: false, servicePopup: true});</script>