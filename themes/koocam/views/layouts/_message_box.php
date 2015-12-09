<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
    <?php echo CHtml::image($themeUrl . '/images/my-message.png', '', array()); ?> 
    <b> My Messages </b> 
    <?php $my_unread_msg_count = Message::getMyUnReadMsgCount(); ?>
    <?php $hideCount = $my_unread_msg_count > 0 ? '' : 'hide'; ?>
    <span class="count <?php echo $hideCount ?>" id="top_msg_count">
        <?php echo $my_unread_msg_count; ?>
    </span>
    <span class="circle"></span>
    <?php // } ?>
</a>
<ul role="menu" class="dropdown-menu notifications  bullet pull-right" >
    <li class="notification-header">
        <em>You have <span class="badge"><?php echo $my_unread_msg_count; ?></span> New Messages </em>
    </li>
    <?php if ($my_unread_msg_count > 0) { ?>

        <?php
        $un_read_msgs = Message::getMyUnReadMsg();
        foreach ($un_read_msgs as $un_read_msg) {
            ?>
            <li>
                <?php
                if (strlen($un_read_msg['message']) > 10)
                    $un_read_msg_text = substr($un_read_msg['message'], 0, 10) . '...';
                else
                    $un_read_msg_text = $un_read_msg['message'];

                echo CHtml::link($un_read_msg_text, array('/site/message/readmessage', 'conversation_id' => $un_read_msg['id1']));
                ?>
                <span class="timestamp">
                    <?php echo Myclass::timeAgo(strtotime(Yii::app()->localtime->toLocalDateTime($un_read_msg['created_at']))); ?>
                </span>
            </li>
        <?php } ?>

    <?php } else { ?>
        <?php
        $read_msgs = Message::getMyReadMsg();
        foreach ($read_msgs as $read_msg) {
            ?>
            <li>
                <?php
                if (strlen($read_msg['message']) > 10)
                    $read_msg_text = substr($read_msg['message'], 0, 10) . '...';
                else
                    $read_msg_text = $read_msg['message'];

                echo CHtml::link($read_msg_text, array('/site/message/readmessage', 'conversation_id' => $read_msg['id1']));
                ?>
                <span class="timestamp">
                    <?php echo Myclass::timeAgo(strtotime(Yii::app()->localtime->toLocalDateTime($read_msg['created_at']))); ?>
                </span>
            </li>
        <?php } ?>
    <?php } ?>
    <li class="notification-header">
        <?php echo CHtml::link("View All Messages", array('/site/message')); ?>
    </li>
</ul>