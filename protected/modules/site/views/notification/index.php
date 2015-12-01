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
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Notifications </h2>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                <div class="table-responsive">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                        <tr>
                            <th width="3%">S. No</th>
                            <th width="20%"> Notification </th>
                            <th width="24%" colspan="2"> Booking Details</th>
                            <th width="18%"> Date </th>
                        </tr>
                        <?php if (empty($results)) { ?>
                            <tr>
                                <td colspan="3"> No Records Found </td>
                            </tr>
                            <?php
                        } else {
                            $i = 1;
                            foreach ($results as $notification) {
                                $mdisplay = $notification->notifn_message;
//                                $mdisplay = (strlen($notification->notifn_message) > 50) ? substr($notification->notifn_message, 0, 50) . '...' : $notification->notifn_message;
                                ?>  
                                <tr>
                                    <td width="3%">
                                        <?php echo $i; ?>
                                    </td>
                                    <td width="20%">
                                        <?php echo $mdisplay; ?>
                                    </td>
                                    <td width="16%">
                                        <?php
                                        if(!empty($notification->gigBooking)){
                                            $booking = $notification->gigBooking;
                                            echo "User: {$booking->bookUser->fullname} <br/>";
                                            echo "Date: ".date(PHP_SHORT_DATE_FORMAT, strtotime($booking->book_date))." <br/>";
                                            echo "Time: ".date("H:i", strtotime($booking->book_start_time)).' - '.date("H:i", strtotime($booking->book_end_time))." <br/>";
                                        }
                                        ?>
                                    </td>
                                    <td width="8%">
                                        <?php
                                        if(!empty($notification->gigBooking) && $notification->gigBooking->book_approve == 0){
                                            echo CHtml::link('Approve', array('/site/notification/approve', 'id' => $notification->notifn_id), array('onclick' => 'return confirm("Are you sure to approve ?")'));
                                        }elseif($notification->gigBooking->book_approve == 1){
                                            echo 'Approved';
                                        }
                                        ?>
                                    </td>
                                    <td width="18%">
                                        <?php echo Yii::app()->localtime->toLocalDateTime($notification['created_at'], 'medium', 'medium'); ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php if (!empty($results)) { ?>
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
    </div>
</div>