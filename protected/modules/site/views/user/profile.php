<?php
/* @var $this DefaultController */
/* @var $model User */
/* @var $user_profile UserProfile */
/* @var $message Message */

$this->title = 'Koocam - Profile';
$themeUrl = $this->themeUrl;

$is_user = !Yii::app()->user->isGuest && Yii::app()->user->id == $model->user_id;
$is_not_my_profile = !Yii::app()->user->isGuest && Yii::app()->user->id != $model->user_id;
?>

<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">
                <h2> 
                    <?php echo CHtml::link($model->username, array('/site/user/profile', 'slug' => $model->slug)); ?> 
                    <?php if ($is_user) { ?>
                        <button class="btn btn-default edit-btn" data-toggle="modal" data-target=".bs-example-modal-sm2" data-dismiss=".bs-example-modal-sm2"> <i class="fa fa-pencil"></i> </button>
                    <?php } ?>
                </h2>
                <?php echo CHtml::link($user_profile->prof_tag, '#'); ?>
                <br/>
                <?php
                $this->widget('ext.DzRaty.DzRaty', array(
                    'name' => 'user_rating',
                    'value' => $model->user_rating,
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
        </div>
    </div>
</div>

<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="course-img">
                    <?php echo $model->userstatusicon; ?>
                    <?php echo $model->profileimage; ?>
                </div>
                <div class="row">
                    <?php if ($is_not_my_profile) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <a href="#" class="big-btn btn btn-default " data-toggle="modal" data-target=".bs-example-modal-profile-msg" data-dismiss=".bs-example-modal-profile-msg"> <i class="fa fa-envelope-o"></i> Message </a>
                        </div>
                    <?php } ?>
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
                <p class="date"> Date of Join : <?php echo $model->created_at; ?></p>
                <p><?php echo $user_profile->prof_about; ?></p>
                <h4> Country </h4>
                <p> <?php echo $model->userCountry->country_name; ?> </p>
                <h4> Languages </h4>
                <p> <?php echo $model->languages ?> </p>
                <h4> Interests </h4>
                <p> <?php echo $user_profile->prof_interests; ?></p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comentslist-cont relateditems">
                <h2> Reflection  <?php echo $model->username; ?> cams</h2>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php
            $cams = Cam::topInstructors($model->user_id);
            $this->renderPartial('/cam/_cam_carousal', compact('cams', 'themeUrl'));
            ?>
        </div>
    </div>
</div>

<?php
if ($is_user) {
    $this->renderPartial('_profile_edit', compact('model', 'user_profile'));
}

if ($is_not_my_profile) {
    $this->renderPartial('_profile_message', compact('model', 'user_profile', 'message'));
}
?>

<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "b111ba58-0a07-447e-92ed-da6eda1af9b3", doNotHash: false, doNotCopy: false, hashAddressBar: false, servicePopup: true});</script>