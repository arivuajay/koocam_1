<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */

$this->title = 'Messages - Conversation';
$this->breadcrumbs = array(
    'Messages - Conversation',
);

$session_userid = Yii::app()->user->id;

if ($u1 != $session_userid) {
    $userto_id = $u1;
}
if ($u2 != $session_userid) {
    $userto_id = $u2;
}
?>
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Messages - Conversation </h2>
            </div>
        </div>
    </div>
</div>

<div class="innerpage-cont">
    <div class="container">
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                <div class="nano">
                    <div class="table-responsive nano-content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                            <tr>          
                                <th class="author">User</th>
                                <th>Message</th>
                                <th>Sent</th>
                            </tr>
                            <?php foreach ($mymessages as $minfos) { ?>
                                <tr>
                                    <td><?php echo $minfos['username']; ?></td>
                                    <td><?php echo $minfos['message']; ?></td>
                                    <td><?php echo Yii::app()->localtime->toLocalDateTime($minfos['created_at']); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>     
            </div>    
        </div>

        <?php $this->renderPartial('_reply_message', compact('model', 'userto_id', 'mymessages')); ?>
    </div>
</div>