<?php
/* @var $this DefaultController */
/* @var $model Gig */
/* @var $tutor User */
/* @var $gig_comments GigComments */

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
                <p><?php echo $tutor->profilethumb; ?></p>
                <h2><?php echo CHtml::link($tutor->fullname, array('/site/user/profile', 'slug' => $tutor->slug)); ?></h2>
                <?php echo CHtml::link($tutor->userProf->prof_tag, '#'); ?><br/>
                <?php
                $this->widget('ext.DzRaty.DzRaty', array(
                    'name' => 'gig_rating',
                    'value' => $model->gig_rating,
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
                <?php $this->renderPartial('_view_image', compact('model')); ?>
                <div class="row">
                    <?php
                    $model->setButtonOptions();
                    if (!is_null($model->startnowButton)) {
                        echo "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'> {$model->startnowButton} </div>";
                    }
                    if (!is_null($model->bookingButton)) {
                        echo "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'> {$model->bookingButton} </div>";
                    }
                    if (!is_null($model->messageButton)) {
                        echo "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'> {$model->messageButton} </div>";
                    }
                    ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sharethis-share">
                        <span class='st_facebook_large custom-share' displayText='Facebook'></span>
                        <span class='st_twitter_large custom-share' displayText='Tweet'></span>
                        <span class='st_googleplus_large custom-share' displayText='Google +'></span>
                        <span class='st_sharethis_large custom-share' displayText='ShareThis'></span>
                    </div>
                    <?php // if ($logged_user) { ?>
                    <!--<a href="#" data-target="#comments" data-toggle="modal">Comments</a>-->
                    <?php // } ?>
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
            <?php $this->renderPartial('_comments', compact('model')); ?>
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
if ($logged_user) {
    $this->renderPartial('_booking_form', compact('model', 'booking_model'));
    $this->renderPartial('_startnow_form', compact('model', 'booking_temp'));
    $this->renderPartial('_comments_form', compact('model', 'gig_comments'));
    $this->renderPartial('_message_form', compact('model', 'message'));
}
?>

<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "b111ba58-0a07-447e-92ed-da6eda1af9b3", doNotHash: false, doNotCopy: false, hashAddressBar: false, servicePopup: true});</script>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/bootstrap-timepicker.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/jquery.countdown.min.js', $cs_pos_end);

$js = <<< EOD
    jQuery(document).ready(function ($) {

        extra_div = $('.extras-prices-bg');

        $('#book_extra_main').on('ifChecked', function(event){
            var newPrice = parseFloat(extra_div.data('gig_price')) + parseFloat(extra_div.data('extra_price'));
            $('.gig_price_txt').html('$ '+newPrice);
            $('#temp_book_extra_inner').iCheck('check'); 
            $('#book_extra_inner').iCheck('check'); 
        });

        $('#book_extra_main').on('ifUnchecked', function(event){
            var newPrice = parseFloat(extra_div.data('gig_price'));
            $('.gig_price_txt').html('$ '+newPrice);
            $('#temp_book_extra_inner').iCheck('uncheck'); 
            $('#book_extra_inner').iCheck('uncheck'); 
        });

        $('#booking').on('shown.bs.modal', function () {
            $('#booking-cal').trigger( 'destroy' );
            $('#booking-cal').fullCalendar('render');
        });
    });
EOD;
Yii::app()->clientScript->registerScript('view', $js);
?>