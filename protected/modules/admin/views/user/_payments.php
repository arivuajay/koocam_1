<?php

$gridColumns = array(
    array(
        'class' => 'IndexColumn',
        'header' => '',
    ), 
    array(
        'header' => 'Date',
        'value' => '$data->created_at',
    ),
    array(
        'header' => 'Description',
        'type' => 'raw',
        'value' => function($data) {
            if ($data->trans_type == Transaction::TYPE_REVENUE) {
                $txt = '<p > Cam: '.$data->booking->cam->cam_title.'</p>';
                $txt .= '<p class="paid"> User Paid :'.$data->booking->book_total_price;
                $txt .= '</p>';
                $txt .= '<p>(Inc. Processing & Service Tax)</p>';
            } elseif ($data->trans_type == Transaction::TYPE_WITHDRAW) { 
                $txt = '<p class="paid"> Paypal : '.$data->paypal_address.'</p>';
                $txt .= '<p class="paid"> Cash Out ';
                if($data->status == 0){
                    $txt .= '<span class="label label-default">Processing</span>';
                }elseif ($data->status == 2) {
                    $txt .= '<span class="label label-danger">Rejected</span>';
                }
                $txt .= '</p>';
            }
            echo $txt;
        }
    ),
    'trans_admin_amount',
    'trans_user_amount',
    /*
      'transaction_id',
      'trans_message',
      'paypal_address',
      'trans_reply',
      array(
      'header' => 'Status',
      'name' => 'status',
      'type' => 'raw',
      'value' => function($data) {
      echo ($data->status == 1) ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
      },
      ),
     */
);

$this->widget('application.components.MyExtendedGridView', array(
    'filter' => $payments_model,
    'type' => 'striped bordered',
    'dataProvider' => $payments_model->search(),
    'responsiveTable' => true,
    "itemsCssClass" => "table v-middle",
    'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
    'columns' => $gridColumns
        )
);
?>