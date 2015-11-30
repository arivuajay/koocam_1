<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $tutor User */
$this->title = "View - {$model->gig_title}";
$themeUrl = $this->themeUrl;
$tutor = $model->tutor;

$is_tutor = !Yii::app()->user->isGuest && Yii::app()->user->id == $model->tutor_id;
$logged_user = !$is_tutor && !Yii::app()->user->isGuest;
?>
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details user-details">
                <?php $url = Yii::app()->createAbsoluteUrl(UPLOAD_DIR . '/users/' . $tutor->user_id . '/thumb' . $tutor->userProf->prof_picture); ?>
                <p> <?php echo CHtml::image($url, '', array('class' => 'img-circle')); ?></p>
                <h2><?php echo CHtml::link($tutor->fullname, array('/site/default/profile', 'slug' => $tutor->slug), array()); ?></h2>
                <?php echo CHtml::link($tutor->userProf->prof_tag, '#', array()); ?><br/>
                <?php echo CHtml::image($themeUrl . '/images/ratings.png', '', array()); ?> </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="course-img">
                    <div class="price-bg"> <?php echo $model->gig_duration; ?> min<br/>
                        <b class="gig_price_txt"> $ <?php echo $gig_price = (int) $model->gig_price; ?> </b></div>
                    <div class="online" data-toggle="tooltip" data-placement="bottom" title="online"> </div>
                    <?php echo CHtml::image($model->getFilePath(false, '/users/' . $tutor->user_id), '', array()); ?></div>
                <div class="row">
                    <?php if (!$is_tutor) { ?>
                        <?php if ($logged_user) { ?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="#" class="big-btn btn btn-default"> <i class="fa fa-video-camera"></i> Start Now ! </a> </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="#" class="big-btn btn btn-default big-btn2" data-toggle="modal" data-target="#booking"> <i class="fa fa-pencil"></i> Booking </a> </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="#" class="big-btn btn big-btn3 btn-default "> <i class="fa fa-envelope-o"></i> Message </a> </div>
                        <?php } else { ?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1" data-dismiss=".bs-example-modal-sm" class="big-btn btn btn-default"> <i class="fa fa-video-camera"></i> Start Now ! </a> </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1" data-dismiss=".bs-example-modal-sm" class="big-btn btn btn-default big-btn2" data-toggle="modal" data-target="#booking"> <i class="fa fa-pencil"></i> Booking </a> </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1" data-dismiss=".bs-example-modal-sm" class="big-btn btn big-btn3 btn-default "> <i class="fa fa-envelope-o"></i> Message </a> </div>
                        <?php } ?>
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
                <h2> <?php echo $model->gig_title; ?></h2>
                <?php if ($is_tutor) { ?>
                    <button class="btn btn-default edit-btn" data-toggle="modal" data-target=".bs-example-modal-sm2" data-dismiss=".bs-example-modal-sm2" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl('/site/gig/update', array('id' => $model->gig_id)) ?>'"> <i class="fa fa-pencil"></i> </button>
                <?php } ?>
                <p class="date"> Created Date : <?php echo date(PHP_SHORT_DATE_FORMAT, strtotime($model->created_at)); ?></p>
                <p><?php echo $model->gig_description; ?></p>
                <h4 class="importants-heading"> Importants </h4>
                <p> <?php echo $model->gig_important; ?> </p>
                <h4> Country </h4>
                <p> <?php echo $tutor->userProf->country->country_name; ?></p>
                <h4> Languages </h4>
                <p> <?php echo $tutor->languages; ?></p>
                <h4> Interests </h4>
                <p><?php echo $tutor->userProf->prof_interests; ?></p>
            </div>
            <?php if ($model->is_extra == 'Y') { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="gig-extras">
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                <h2> Extras </h2>
                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-11 col-lg-11 extras-txt">  
                                <input type="checkbox" class="book_extra_check" id="book_extra_main" > <?php echo $model->gigExtras->extra_description; ?>
                            </div>
                            <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1 "> 
                                <div class="extras-prices-bg" data-gig_price="<?php echo $gig_price; ?>" data-extra_price="<?php echo $extra_price = (int) $model->gigExtras->extra_price; ?>">
                                    <?php echo $extra_price; ?> $
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 comentslist-cont">
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
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comentslist-cont relateditems">  
            <h2> Related Items</h2>
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

<?php
if ($logged_user)
    echo $this->renderPartial('_booking_form', compact('model', 'booking_model'));
?>

<!--<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "b111ba58-0a07-447e-92ed-da6eda1af9b3", doNotHash: false, doNotCopy: false, hashAddressBar: false, servicePopup: true});</script>-->

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/bootstrap-timepicker.js', $cs_pos_end);

$js = <<< EOD
    jQuery(document).ready(function ($) {
        
        extra_div = $('.extras-prices-bg');
        
        $('#book_extra_main').on('ifChecked', function(event){
            var newPrice = parseFloat(extra_div.data('gig_price')) + parseFloat(extra_div.data('extra_price'));
            $('.gig_price_txt').html('$ '+newPrice);
        });
        
        $('#book_extra_main').on('ifUnchecked', function(event){
            var newPrice = parseFloat(extra_div.data('gig_price'));
            $('.gig_price_txt').html('$ '+newPrice);
        });
        
    });
EOD;
Yii::app()->clientScript->registerScript('view', $js);
?>