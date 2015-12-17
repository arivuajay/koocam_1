<?php
/* @var $this PurchaseController */
/* @var $model Purchase */
/* @var $results Purchase[] */
/* @var $purchase Purchase */
/* @var $form CActiveForm */
/* @var $book CamBooking */
/* @var $cam Cam */

$this->title = 'My Purchase';
$themeUrl = $this->themeUrl;
?>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $key => $purchase): ?>
                <div class="purchase-cont"> 
                    <?php
                    $book = $purchase->book;
                    $cam = $book->cam;
                    ?>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 purchase-img">
                            <?php
                            $image = $cam->camthumb;
                            echo CHtml::link($image, array('/site/cam/view', 'slug' => $cam->slug));
                            ?>                
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 purchase-cam">
                            <h2> <?php echo CHtml::link($cam->cam_title, array('/site/cam/view', 'slug' => $cam->slug)); ?></h2>
                            <p> <span> <?php echo CHtml::link($cam->tutor->fullname, array('/site/user/profile', 'slug' => $cam->tutor->slug)); ?> </span> </p>
                            <?php if (!empty($purchase->book->camComment)) { ?>
                                <p>
                                    <?php
                                    echo CHtml::link('View Comment', 'javascript:void(0)', array('data-comment-id' => $purchase->book->camComment->com_id, 'class' => 'btn btn-primary view-comment btn-xs'));
                                    ?>
                                </p>
                                <?php
                                $comment = $purchase->book->camComment;
                                $this->renderPartial("_view_comment", array("com_id" => $comment->com_id, "rating" => $comment->com_rating, "comment" => $comment->com_comment));
                                ?> 
                            <?php } else { ?>
                                <p>
                                    <?php
                                    echo CHtml::link('Write Comment', 'javascript:void(0)', array('data-cam-id' => $cam->cam_id, 'data-cam-booking-id' => $purchase->book_id, 'class' => 'btn btn-primary write-comment btn-xs'));
                                    ?>
                                </p>
                            <?php } ?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 purchase-cam">
                            <p> <b> Date : </b>  <?php echo date(PHP_SHORT_DATE_FORMAT, strtotime($book->book_date)); ?>  </p>
                            <p> <b>Time : </b>  <?php echo date('H:i', strtotime($book->book_start_time)) . ' - ' . date('H:i', strtotime($book->book_end_time)); ?> </p>
                            <p> <b>Sessions :</b>  <?php echo $book->book_session; ?> </p> 
                            <p> <b>Extras :</b>  <?php echo $book->book_is_extra == 'Y' ? 'Yes' : 'No'; ?> </p>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 "> 
                            <div class="purchase-price"> 
                                <h2> $ <?php echo (float) $book->book_total_price; ?> </h2>
                                <span> <i class="fa fa-clock-o"></i> <?php echo $book->book_duration; ?> min</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h4 class="text-center">No Purchase Found</h4>
        <?php endif; ?>
        <div class="pagination-cont">
            <nav>
                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
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

<!--View Comment-->
<div class="modal fade" id="view-comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">View Comment Details</h4>
            </div>
            <div class="modal-body">
                <div class="popup-calendaer-cont" id="comment-cont-popup"></div>
            </div>
        </div>
    </div>
</div>

<?php
$this->renderPartial('/cam/_comments_form', array('model' => new Cam, 'cam_comments' => $cam_comments));

$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$js = <<< EOD
    jQuery(document).ready(function ($) {
        $('.view-comment').on('click', function(){
            id = $(this).data('comment-id');
            $('#comment-cont-popup').html($('#details'+id).html());
            $('#view-comment').modal('show');
        });
        
        $('.write-comment').on('click', function(){
            cam_id = $(this).data('cam-id');
            cam_book_id = $(this).data('cam-booking-id');
            $('#CamComments_cam_id').val(cam_id);
            $('#CamComments_cam_booking_id').val(cam_book_id);
            $('#comments').modal('show');
        });
    });
EOD;
Yii::app()->clientScript->registerScript('mypurchase', $js);
?>