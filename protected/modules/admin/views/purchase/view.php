<?php
/* @var $this PurchaseController */
/* @var $model Purchase */

$this->title = 'View Purchase';
$this->breadcrumbs = array(
    'Purchases' => array('index'),
    $this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-reply"></i> Back', array('/admin/purchase/index'), array("class" => "btn btn-inverse pull-right"));
?>


<div class="container-fluid">
    <div class="page-section third">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'nullDisplay' => '-',
            'attributes' => array(
                'user.username',
                'user.email',
                'user.userProf.company_name',
                'user.userProf.company_id',
                'user.userProf.company_address',
                'book.cam.cam_title',
                'order_id',
                array(
                    'name' => 'book.book_date',
                    'value' => date(PHP_SHORT_DATE_FORMAT, strtotime($model->book->book_date))
                ),
                array(
                    'name' => 'book.book_start_time',
                    'value' => date('H:i', strtotime($model->book->book_start_time))
                ),
                array(
                    'name' => 'book.book_end_time',
                    'value' => date('H:i', strtotime($model->book->book_end_time))
                ),
                'book.book_duration',
                'book.book_session',
                'book.book_total_price',
                array(
                    'name' => 'book.book_service_tax',
                    'type' => 'raw',
                    'value' => $model->book->book_service_tax == '0.00' ? '<span class="label label-danger">17% was not charged</span>' : '<span class="label label-success">17% was charged</span>'
                ),
                array(
                    'name' => 'user.userCountry.country_name',
                    'value' => $model->user->userCountry->country_name
                ),
                array(
                    'name' => 'book.book_is_extra',
                    'type' => 'raw',
                    'value' => $model->book->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>'
                ),
                'created_at',
            ),
        ));
        ?>

    </div>
</div>
