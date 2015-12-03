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
                        $mdisplay = (strlen($messages['message']) > 200) ? substr($messages['message'], 0, 200) . '...' : $messages['message'];
                        $unread_class = '';
                        if ($messages['user2'] == Yii::app()->user->id && $messages['user2read'] == Message::USER_READ_NO) {
                            $unread_class = 'unread';
                        }
                        ?>  
                        <div class="message-row <?php echo $unread_class; ?>">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                    <div class="message-title"> 
                                        <?php echo $mdisplay; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 message-from"> 
                                            <?php
                                            if ($messages['user1'] == Yii::app()->user->id)
                                                $find_from_to = "To: ";
                                            elseif ($messages['user2'] == Yii::app()->user->id)
                                                $find_from_to = "From: ";
                                            ?>
                                            <?php echo $find_from_to;?> <a href="#"> <?php echo $messages['username']; ?> </a> 
                                        </div>
                                        <?php if ($messages['gig_id']) { ?>
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 message-from message-gig"> 
                                                Gig: <a href="#"> Vestibulum bibendum pulvinar orci non lobortis  ? </a> 
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 mesage-details-right">
                                    <div class="mesage-details-row1"> 
                                        <?php
                                        echo CHtml::link('View', array('/site/message/readmessage', 'conversation_id' => $messages['id1']));
                                        ?> | 
                                        <span  data-toggle="tooltip" data-placement="bottom" title="Delete"> 
                                            <a href="#"> <i class="fa fa-trash-o"></i> </a> 
                                        </span> 
                                    </div>
                                    <div class="mesage-details-2">
                                        <?php $message_date = Yii::app()->localtime->fromUTC($messages['created_at']); ?>
                                        <p> 
                                            <i class="fa fa-clock-o"></i> <?php echo date("H:i", strtotime($message_date)); ?>
                                            &nbsp;<span> <?php echo date("d M, Y", strtotime($message_date)); ?> </span> 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<h3>No Message</h3>";
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
