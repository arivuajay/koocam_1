<?php
/* @var $this Controller */
$themeUrl = $this->themeUrl;
?>
<div class="header-cont">
    <div class="container homepage-txt">
        <div class="row">
            <div class="header-row1">
                <div class="col-xs-9 col-sm-4 col-md-4 col-lg-5 logo"> 
                    <?php
                    $text = CHtml::image($themeUrl . '/images/logo.png', '');
                    echo CHtml::link($text, $this->homeUrl);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-7  menu">
                    <nav class="navbar navbar-default"> 
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button aria-expanded="false" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> 
                                <span class="sr-only">Toggle navigation</span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                            </button>
                            <!--  <a href="#" class="navbar-brand">Brand</a> --> 
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                            <?php
//                            $this->widget('zii.widgets.CMenu', array(
//                                'activateParents' => true,
//                                'encodeLabel' => false,
//                                'activateItems' => true,
//                                'items' => array(
//                                    array('label' => 'Sell your time', 'url' => array('/site/gig/create')),
//                                    array('label' => 'How it works', 'url' => array('/site/cms/view', 'slug' => 'how-it-works')),
//                                    array('label' => 'LOG OUT', 'url' => array('/site/default/logout'), 'visible' => !Yii::app()->user->isGuest),
//                                    array('label' => 'LOGIN', 'url' => '#', 'linkOptions' => array('data-toggle' => "modal", 'data-target' => ".bs-example-modal-sm1"), 'visible' => Yii::app()->user->isGuest),
//                                    array('label' => 'SIGN UP', 'url' => '#', 'linkOptions' => array('data-toggle' => "modal", 'data-target' => ".bs-example-modal-sm"), 'visible' => Yii::app()->user->isGuest),
//                                ),
//                                'htmlOptions' => array('class' => 'nav navbar-nav')
//                            ));
                            ?>
                            <ul class="nav navbar-nav">
                                <li><?php echo CHtml::link(' Sell your time ', array('/site/gig/create'), array()); ?></li>
                                <li><?php echo CHtml::link(' How its works ', array('/site/cms/view', 'slug' => 'how-it-works'), array()); ?></li>
                                <?php if(!Yii::app()->user->isGuest){ ?>
                                <li>
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
                                        <?php echo CHtml::image($themeUrl.'/images/my-jobs.png', '', array()); ?> <b> My Jobs </b> <span class="count">15</span>
                                        <span class="circle"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
                                        Calender will come :)
                                    </ul>
                                </li>
                                <li>
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
                                        <?php echo CHtml::image($themeUrl.'/images/my-message.png', '', array()); ?> <b> My Messages </b> <span class="count">5</span>
                                        <span class="circle"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
                                        <li class="notification-header">
                                            <em>You have 4 Messages</em>
                                        </li>
                                        <li><a href="#">Message title 1</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">Message title 2</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">Message title 3</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">Message title 4</a>  <span class="timestamp">1 min ago</span></li>
                                    </ul>
                                </li>
                                <li>
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" >
                                        <?php echo CHtml::image($themeUrl.'/images/my-notification.png', '', array()); ?> <b> My Notifications </b> <span class="count">5</span>
                                        <span class="circle"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
                                        <li class="notification-header">
                                            <em>You have 5 notifications</em>
                                        </li>
                                        <li><a href="#">New comments For Your Gig</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">New comments For Your Gig</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">New comments For Your Gig</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">New comments For Your Gig</a>  <span class="timestamp">1 min ago</span></li>
                                        <li><a href="#">New comments For Your Gig</a>  <span class="timestamp">1 min ago</span></li>


                                    </ul>
                                </li>
                                <li role="presentation" class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <?php echo Yii::app()->user->name; ?> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu2 pull-right bullet" >
                                        <li><?php echo CHtml::link(' My Profile ', array('/site/user/profile', 'slug' => Yii::app()->user->slug), array()); ?></li>
                                        <li><a href="#">My Profile</a></li>
                                        <li><a href="#">My Purchase</a></li>
                                        <li><a href="#">My Payments</a></li>
                                        <li class="divider" role="separator"></li>
                                        <li><a href="#"> <i class="fa fa-gears"></i>&nbsp; Account Setting</a></li>    
                                        <li><?php echo CHtml::link(' Logout', array('/site/default/logout'), array()); ?></li>
                                    </ul>
                                </li>
                                <?php }else{ ?>
                                    <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm1"> Login </a></li>
                                    <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm"> Sign up</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse --> 
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
