<?php $this->beginContent('//layouts/main'); ?>

<?php
if (isset($this->flashMessages) && !empty($this->flashMessages)):
    $key = key($this->flashMessages);
    $message = $this->flashMessages[$key];
    $js = <<< EOD
    jQuery(document).ready(function ($) {
        $.smkAlert({text:'{$message}', type:'{$key}', time: 25});
    });

EOD;

    Yii::app()->clientScript->registerScript('user_dashboard', $js);
endif
?>

<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2><?php echo $this->title ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="profiles-left">
                    <div class="profile-img2"> 
                        <?php echo CHtml::image('images/profile-img2.jpg')?>
                    </div>
                </div>
                <div class="profile-img2">
                    <div class="profile-details">
                        <h2> PETER PARKER </h2>
                        <p> Expert in 3D Graphics </p>
                        <p> <img src="images/ratings.png"  alt=""></p>
                    </div>
                    <div class="profiles-list">
                        <ul>
                            <li> <a href="#"> <i class="fa fa-user"></i> My Profile</a> </li>
                            <li> <a href="#"> <i class="fa fa-graduation-cap"></i> My Gigs</a> <span class="badge">4</span></li>
                            <li> <a href="#"> <i class="fa fa-cart-plus"></i> My Purchase</a> <span class="badge">4</span></li>
                            <li> <a href="#"> <i class="fa fa-money"></i> My Payments</a> <span class="badge"> $1234</span></li>
                            <li class="myprofile-active"> <a href="#"> <i class="fa fa-envelope"></i> Messages</a> <span class="badge">20</span></li>
                            <li> <a href="#"> <i class="fa fa-bell"></i> Notifications</a> <span class="badge">20</span></li>
                            <li> <a href="#"> <i class="fa fa-calendar-check-o"></i> Jobs</a> <span class="badge">20</span></li>
                            <li> <a href="#"><i class="fa fa-gear"></i> Account Setting</a> <span class="badge">20</span></li>
                            <li> <a href="#"> <i class="fa fa-power-off"></i> Logout</a> <span class="badge">20</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php echo $content; ?>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>