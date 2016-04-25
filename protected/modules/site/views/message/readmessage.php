<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */

$this->title = 'My Messages';
$this->breadcrumbs = array(
    'Messages',
);

$session_userid = Yii::app()->user->id;

if ($u1 != $session_userid) {
    $userto_id = $u1;
}
if ($u2 != $session_userid) {
    $userto_id = $u2;
}
?>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 message-title">
                <h4> Reply Message </h4>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box" id="box1">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 replies-cont">
                        <?php foreach ($mymessages as $minfos) { ?>
                            <div class="single-message">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1"> 
                                        <?php $user = User::model()->findByPk($minfos['user_id']); ?>
                                        <b> <a href="#"><?php echo $user->profileimage ?></a></b> 
                                    </div>
                                    <div class="col-xs-12 col-sm-7 col-md-9 col-lg-9">
                                        <?php echo nl2br($minfos['message']); ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                        <div class="replymsg-details">
                                            <?php $message_date = Yii::app()->localtime->fromUTC($minfos['created_at']); ?>
                                            <p> 
                                                <i class="fa fa-clock-o"></i> <?php echo date("H:i", strtotime($message_date)); ?>
                                                <br/> &nbsp;<span> <?php echo date("d M, Y", strtotime($message_date)); ?> </span> 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php $this->renderPartial('_reply_message', compact('model', 'userto_id', 'mymessages')); ?>
            </div>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('.box').lionbars();
        
    });
EOD;
Yii::app()->clientScript->registerScript('readmessage', $js);
?>