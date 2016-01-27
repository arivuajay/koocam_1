<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */

$this->title = 'My Messages';
$this->breadcrumbs = array(
    'Messages',
);
?>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <?php
                if (!empty($model)) {
                    foreach ($model as $messages) {
                        $mdisplay = (strlen($messages['message']) > 80) ? substr($messages['message'], 0, 80) . '...' : $messages['message'];
                        $unread_class = '';
                        if ($messages['user2'] == Yii::app()->user->id && $messages['user2read'] == Message::USER_READ_NO) {
                            $unread_class = 'unread';
                        }
                        $user = User::model()->findByPk($messages['user_id']);
                        ?> 
                        <div class="message-row <?php echo $unread_class; ?>">
                            <div class="row">
                                <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1 ">
                                    <?php echo $user->profileimage ?>
                                </div>
                                <div class="col-xs-9 col-sm-6 col-md-8 col-lg-8">
                                    <div class="message-title"> 
                                        <?php echo CHtml::link($messages['username'], array('/site/user/profile', 'slug' => $user->slug)) ?>
                                        <span> <?php echo "( " . $messages['reps'] . " Messages)" ?> </span>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 message-txt"> 
                                            <?php echo $mdisplay; ?>
                                        </div>
                                        <?php if ($messages['cam_id']) { ?>
                                            <?php $cam = Cam::model()->findByPk($messages['cam_id']); ?>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 message-from message-cam"> 
                                                <b> Cam: </b> 
                                                <?php
                                                echo CHtml::link($cam->cam_title, array('/site/cam/view', 'slug' => $cam->slug))
                                                ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 mesage-details-right">
                                    <div class="mesage-details-row1"> 
                                        <?php echo CHtml::link('View', array('/site/message/readmessage', 'conversation_id' => $messages['id1']), array("class" => "btn btn-default")); ?> | 
                                        <span  data-toggle="tooltip" data-placement="bottom" title="Delete"> 
                                            <?php
                                            echo CHtml::link('<i class="fa fa-trash-o"></i> ', array('/site/message/delete', 'conversation_id' => $messages['id1']), array('confirm' => 'Are you sure?')
                                            );
                                            ?>
                                        </span> 
                                    </div>
                                    <div class="mesage-details-2">
                                        <?php $message_date = Yii::app()->localtime->fromUTC($messages['created_at']); ?>
                                        <p> 
                                            <i class="fa fa-clock-o"></i> 
                                            <?php echo date("H:i", strtotime($message_date)); ?> 
                                            &nbsp;<span> <?php echo date("d M, Y", strtotime($message_date)); ?></span> 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<h4 class = 'text-center'>No Message</h3>";
                }
                ?>
            </div>
        </div>
        <?php if (!empty($model)) { ?>
            <div class="pagination-cont">
                <nav>
                    <?php
                    $this->widget('CLinkPager', array(
                        'pages' => $dataProvider->pagination,
                        "cssFile" => false,
                        'header' => '',
                        'htmlOptions' => array('class' => 'pagination'),
                        'prevPageLabel' => '<span aria-hidden="true">«</span></a>',
                        'firstPageLabel' => '<span aria-hidden="true">« First</span></a>',
                        'nextPageLabel' => '<span aria-hidden="true">»</span>',
                        'lastPageLabel' => '<span aria-hidden="true">Last »</span>',
                        'selectedPageCssClass' => 'active',
                        'selectedPageCssClass' => 'active',
                        'maxButtonCount' => 5,
                        'id' => 'link_pager',
                    ));
                    ?>
                </nav>
            </div>
        <?php } ?>
    </div>
</div>
