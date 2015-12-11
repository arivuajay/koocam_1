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
                                <li><?php echo CHtml::link(' Sell your time ', array('/site/gig/create')); ?></li>
                                <li><?php echo CHtml::link(' How its works ', array('/site/cms/view', 'slug' => 'how-it-works')); ?></li>
                                <?php
                                if (!Yii::app()->user->isGuest) {
                                    $user = User::model()->findByPk(Yii::app()->user->id);
                                    ?>
                                    <li>
                                        <?php
                                        $img = CHtml::image($themeUrl . '/images/my-jobs.png', '');
                                        echo CHtml::link($img . '<b> My Jobs </b>', '#', array('class' => '', 'data-toggle' => "modal", 'data-target' => "#booking-2"));
                                        ?>
                                    </li>
                                    <li id="li_message_top">
                                        <?php $this->renderPartial('//layouts/_message_box', compact('themeUrl')); ?>
                                    </li>
                                    <li id="li_notifn_top">
                                        <?php $this->renderPartial('//layouts/_notification_box', compact('themeUrl')); ?>
                                    </li>
                                    <li role="presentation" class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <?php echo ucfirst(Yii::app()->user->name); ?> <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu2 pull-right bullet" >
                                            <?php $slug = User::model()->findByPk(Yii::app()->user->id)->slug; ?>
                                            <li><?php echo CHtml::link(' My Profile ', array('/site/user/profile', 'slug' => $slug)); ?></li>
                                            <li><?php echo CHtml::link(' My Gigs ', array('/site/gig/mygigs')); ?></li>
                                            <li><?php echo CHtml::link(' My Purchase ', array('/site/purchase/mypurchase')); ?></li>
                                            <li><?php echo CHtml::link(' My Payments ', array('/site/transaction/mypayments')); ?></li>
                                            <li class="divider" role="separator"></li>
                                            <li><?php echo CHtml::link(' <i class="fa fa-gears"></i>&nbsp; Account Setting ', array('/site/user/accountsetting')); ?></li>
                                            <li><?php echo CHtml::link(' <i class="fa fa-power-off"></i>&nbsp; Logout', array('/site/default/logout')); ?></li>
                                        </ul>
                                    </li>
                                    <li id="user_status_li">
                                        <?php echo $user->statusbutton;?>
                                    </li>
                                <?php } else { ?>
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

<?php
if (!Yii::app()->user->isGuest) {
    $this->renderPartial('//layouts/_calendar_box', compact('themeUrl'));
    
    $cs = Yii::app()->getClientScript();
    $cs_pos_end = CClientScript::POS_END;
    $mode_url = Yii::app()->createAbsoluteUrl('/site/user/switchstatus');
    $user_id = Yii::app()->user->id;

    $js = <<< EOD
    jQuery(document).ready(function ($) {
        $('#switch_status').on('click', function(){
            _that = $(this);
            
            var mode = _that.data('mode');
            var user_id = '{$user_id}';
            
            if(mode == 'A' || mode == 'O'){
                _that.tooltip("hide")
                new_mode = mode == 'A' ? 'O' : 'A';
            
                $.ajax({
                    type: 'POST',
                    url: '$mode_url',
                    data: {'mode': new_mode, 'user_id': user_id},
                    success:function(data){
                        if(mode == 'A'){
                            _that.addClass('offline-btn').removeClass('online-btn');
                            _that.data('mode', 'O');
                            _that.attr('data-original-title', 'Offline');
                        }else if(mode == 'O'){
                            _that.addClass('online-btn').removeClass('offline-btn');
                            _that.data('mode', 'A');
                            _that.attr('data-original-title', 'Online');
                        }
                        _that.tooltip("toggle")
                    },
                    error: function(data) {
                        alert("Something went wrong. Try again");
                    },
                });
            }
                    
        });
    });
        
EOD;
    Yii::app()->clientScript->registerScript('_headerBar', $js);
}
?>
