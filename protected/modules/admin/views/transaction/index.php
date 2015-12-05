<?php
/* @var $this TransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Transactions';
$this->breadcrumbs=array(
	$this->title,
);
$this->rightCornerLink = CHtml::link('<i class="fa fa-plus"></i> Create transaction', array('/admin/transaction/create'), array("class" => "btn btn-warning pull-right"));
?>

<div class="container-fluid">
    <div class="page-section third">
        <div class="row">
            <div class="col-lg-12">
                                <?php
                $gridColumns = array(
                		array(
                                    'class' => 'IndexColumn',
                                    'header' => '',
                                ),		'trans_id',
		'user_id',
		'trans_type',
		'book_id',
		'trans_admin_amount',
		'trans_user_amount',
		/*
		'transaction_id',
		'trans_message',
		'paypal_address',
		'created_at',
		*/
                array(
                'header' => 'Action',
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('class' => 'text-center'),
                'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                )
                );

                $this->widget('application.components.MyExtendedGridView', array(
                'filter' => $model,
                'type' => 'striped bordered',
                'dataProvider' => $model->search(),
                'responsiveTable' => true,
                "itemsCssClass" => "table v-middle",
                'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                'columns' => $gridColumns
                )
                );
                ?>
            </div>
        </div>
    </div>
</div>
