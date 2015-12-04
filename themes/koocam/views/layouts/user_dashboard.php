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

<?php $user = User::model()->findByPk(Yii::app()->user->id); ?>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="profiles-left">
                    <div class="profile-img2"> 
                        <?php echo $user->profileimage ?>
                    </div>
                </div>
                <div class="profile-img2">
                    <div class="profile-details">
                        <h2> PETER PARKER </h2>
                        <p> Expert in 3D Graphics </p>
                        <p> <img src="images/ratings.png"  alt=""></p>
                    </div>
                    <div class="profiles-list">
                        <?php
                        $msg_count = Message::getMyUnReadMsgCount();
                        $msg_badge = '';
                        if($msg_count > 0){
                            $msg_badge = '<span class="badge">'.$msg_count.'</span>';
                        }
                        $this->widget('zii.widgets.CMenu', array(
                            'activateParents' => true,
                            'encodeLabel' => false,
                            'activateItems' => true,
                            'activeCssClass' => 'myprofile-active',
                            'items' => array(
                                array('label' => '<i class="fa fa-user"></i> My Profile', 'url' => '#'),
                                array('label' => '<i class="fa fa-graduation-cap"></i> My Gigs <span class="badge">'.$user->gigcount.'</span>', 'url' => array('/site/gig/mygigs')),
                                array('label' => '<i class="fa fa-cart-plus"></i> My Purchase <span class="badge">'.$user->purchasecount.'</span>', 'url' => array('/site/purchase/mypurchase')),
                                array('label' => '<i class="fa fa-money"></i> My Payments <span class="badge"> $1234</span>', 'url' => '#'),
                                array('label' => '<i class="fa fa-envelope"></i> Messages ' . $msg_badge, 'url' => array('/site/message/index')),
                                array('label' => '<i class="fa fa-bell"></i> Notifications <span class="badge">20</span>', 'url' => '#'),
                                array('label' => '<i class="fa fa-calendar-check-o"></i> Jobs <span class="badge">20</span>', 'url' => '#'),
                                array('label' => '<i class="fa fa-gear"></i> Account Setting <span class="badge">20</span>', 'url' => '#'),
                                array('label' => '<i class="fa fa-power-off"></i> Logout', 'url' =>  array('/site/default/logout')),
                            ),
                            'htmlOptions' => array('class' => 'sidebar-menu')
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <?php echo $content; ?>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>