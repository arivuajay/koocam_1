<?php
/* @var $this NotificationController */
/* @var $notification Notification */
/* @var $booking GigBooking */
/* @var $form CActiveForm */

$this->title = 'Notifications';
$this->breadcrumbs = array(
    'Notifications',
);
?>
<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <div class="row">
            <?php if (empty($results)) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="message-row">
                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <div class="notification-txt text-right"> No Notifications Found</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $i = 1;
                foreach ($results as $notification) {
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="message-row">
                            <div class="row">
                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-8">
                                    <div class="notification-txt"><?php echo $mdisplay = $notification->notifn_message; ?></div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 notification-timing">
                                            <?php $message_date = $notification->created_at; ?>
                                            <div class="mesage-details-2"> 
                                                <span> <?php echo date("d M, Y", strtotime($message_date)); ?></span> , <i class="fa fa-clock-o"></i> <?php echo date("H:i", strtotime($message_date)); ?> 
                                                &nbsp; </div>
                                        </div>
                                        <?php if (!empty($notification->gigBooking)) { ?>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                            echo CHtml::link('View Booking', 'javascript:void(0)', array('data-notifn' => $notification->notifn_id, 'class' => 'btn btn-primary view-notifn btn-xs'));
                                            ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-4 mesage-details-right">
                                    <?php if (empty($notification->gigBooking)) { ?>
                                        <div class="mesage-details-row1"> 
                                            <span  data-toggle="tooltip" data-placement="bottom" title="Delete"> 
                                                <?php echo CHtml::link('<i class="fa fa-trash-o"></i>', array('/site/notification/delete', 'id' => $notification->notifn_id), array('onclick' => 'return confirm("Are you sure to Delete ?")')); ?>
                                            </span> 
                                        </div>
                                        <?php
                                    } elseif (!empty($notification->gigBooking) && strtotime($notification->gigBooking->book_date) >= strtotime(date('Y-m-d')))  {
                                        $booking = $notification->gigBooking;

                                        $book_details = "<div class='form-group'>
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            Booked User : {$booking->bookUser->fullname}
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            Booking Date : " . date(PHP_SHORT_DATE_FORMAT, strtotime($booking->book_date)) . "
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            Time: " . date("H:i", strtotime($booking->book_start_time)) . ' - ' . date("H:i", strtotime($booking->book_end_time)) . "
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            Session: {$booking->book_session}
                                            </div>
                                        </div>";

                                        echo "<div class='hide' id='details{$notification->notifn_id}'>{$book_details}</div>";

                                        $content = '';
//                                        $content .= CHtml::link('View', 'javascript:void(0)', array('data-notifn' => $notification->notifn_id, 'class' => 'btn btn-primary view-notifn'));
//                                        $content .= '&nbsp;&nbsp;|';
                                        $reject_button = CHtml::link('Reject', array('/site/notification/decline', 'id' => $notification->notifn_id), array('onclick' => 'return confirm("Are you sure to Reject ?")', 'class' => 'btn btn-danger'));
                                        $content .= '&nbsp;&nbsp;';
                                        switch ($notification->gigBooking->book_approve) {
                                            case 0:
                                                $content .= '<span class="text-warning">Pending</span>&nbsp;&nbsp;|&nbsp;&nbsp;';
                                                $content .= CHtml::link('Approve', array('/site/notification/approve', 'id' => $notification->notifn_id), array('onclick' => 'return confirm("Are you sure to approve ?")'));
                                                $content .= '&nbsp;&nbsp;|&nbsp;&nbsp;';
                                                $content .= $reject_button;
                                                break;
                                            case 1:
                                                $content .= '<span class="label-success label">Approved</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
                                                $content .= $reject_button;
                                                break;
                                            case 2:
                                                $content .= '<span class="label-danger label">Rejected</span>';
                                                break;
                                        }
                                        echo $content;
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
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
    </div>
</div>
<div class="modal fade" id="view-notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Booking Details</h4>
            </div>
            <div class="modal-body">
                <?php // echo $form->errorSummary($booking_model);     ?>

                <div class="popup-calendaer-cont" id="book-cont-popup">

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$js = <<< EOD
            jQuery(document).ready(function ($) {
                $('.view-notifn').on('click', function(){
                    id = $(this).data('notifn');
                    $('#book-cont-popup').html($('#details'+id).html());
                    $('#view-notification').modal('show');
                });
            });
            
        
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>
