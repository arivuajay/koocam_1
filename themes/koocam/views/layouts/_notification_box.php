<?php
$notifications = Notification::getNotificationsByUserId(Yii::app()->user->id);
$count = count($notifications);
?>
<a data-toggle="dropdown" class="dropdown-toggle" href="#" >
    <?php echo CHtml::image($themeUrl . '/images/my-notification.png', '', array()); ?> <b> My Notifications </b> 
    <?php if ($count > 0) { ?>
        <span class="count"><?php echo $count; ?></span>
        <span class="circle"></span>
    <?php } ?>
</a>
<ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
    <?php
    if (!empty($notifications)) {
        echo "<li class='notification-header'><em>You have {$count} New notifications</em></li>";
        foreach ($notifications as $key => $notification) {
            echo "<li>{$notification->topnotifymessage}</li>";
        }
    } else {
        echo '<li class="notification-header"><em>' . CHtml::link("View All", array('/site/notification')) . '</em></li>';
    }
    ?>
</ul>