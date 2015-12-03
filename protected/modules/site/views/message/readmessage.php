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
                <?php $this->renderPartial('_reply_message', compact('model', 'userto_id', 'mymessages')); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 replies-cont">
                <?php foreach ($mymessages as $minfos) { ?>
                    <div class="single-message">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"> 
                                <b> <a href="#"><?php echo $minfos['username']; ?></a></b> 
                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                                <?php echo $minfos['message']; ?>
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
        <!--        <div class="pagination-cont">
                    <nav>
                        <ul class="pagination">
                            <li class="disabled"><a aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                            <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>-->
    </div>
</div>