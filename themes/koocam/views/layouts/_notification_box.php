<?php
$notifications = Notification::getNotificationsByUserId(Yii::app()->user->id);
$count = count($notifications);
$hideCount = $count > 0 ? '' : 'hide';
?>
<a data-toggle="dropdown" class="dropdown-toggle" href="#" >
    <?php echo CHtml::image($themeUrl . '/images/my-notification.png', '', array()); ?> <b> My Notifications </b> 
    <?php // if ($count > 0) { ?>
    <span class="count <?php echo $hideCount?>" id="top_notifn_count"><?php echo $count; ?></span>
        <span class="circle"></span>
    <?php // } ?>
</a>
<ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
    <?php
    if (!empty($notifications)) {
        echo "<li class='notification-header'><em>You have <span class='badge'>{$count}</span> New notifications</em></li>";
        foreach ($notifications as $key => $notification) {
            echo "<li>{$notification->topnotifymessage}</li>";
        }
    } else {
        echo '<li class="notification-header">' . CHtml::link("View All Notifications", array('/site/notification')) . '</li>';
    }
    ?>
</ul>