<?php
$new_count = Notification::getNotificationCountByUserId(Yii::app()->user->id);
$hideCount = $new_count > 0 ? '' : 'hide';
?>
<a data-toggle="dropdown" class="dropdown-toggle" href="#" >
    <?php echo CHtml::image($themeUrl . '/images/my-notification.png', '', array()); ?> <b> My Notifications </b> 
    <span class="count <?php echo $hideCount ?>" id="top_notifn_count" data-count="<?php echo $new_count ?>"><?php echo $new_count; ?></span>
    <span class="circle"></span>
</a>
<ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
    <li class="notification-header">
        <em>You have <span class="badge"><?php echo $new_count; ?></span> New Notification </em>
    </li>
    <?php
    if ($new_count > 0) {
        $notifications = Notification::getNotificationsByUserId(Yii::app()->user->id);
    } else {
        $notifications = Notification::getNotificationsByUserId(Yii::app()->user->id, 'Y');
    }
    if (!empty($notifications)) {
        foreach ($notifications as $key => $notification) {
            $li_class = '';
            if($key == 0 && $notification->notifn_type == "book" && $notification->notifn_read == "N")
                $li_class = "notif_alert";
            echo "<li class='{$li_class}'>{$notification->topnotifymessage}</li>";
        }
    } else {
        echo '<li><a href="#">No Notifications Found</a></li>';
    }
    echo '<li class="notification-header">' . CHtml::link("View All Notifications", array('/site/notification')) . '</li>';
    ?>
</ul>