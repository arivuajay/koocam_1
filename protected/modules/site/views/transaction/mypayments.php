<?php
/* @var $this TransactionController */
/* @var $model Transaction */
/* @var $form CActiveForm */

$this->title = 'My Payments';
$this->breadcrumbs = array(
    'My Payments',
);

$balance = Transaction::myCurrentBalance();
if ($balance > 0)
    $this->renderPartial('_cash_withdraw', compact('model'));
?>
<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 total-expense"> 
                <p> Total Expenses : <span> $ <?php echo $expense = Transaction::myTotalExpense(); ?> </span> </p>
                <p> Total Revenues :  <b> $ <?php echo $revenue = Transaction::myTotalRevenue(); ?> </b> </p>
                <p> Current Balance : <b> $ <?php echo $balance; ?> </b> </p>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                        <?php
                        if ($balance > 0)
                            echo CHtml::link('$ CASH OUT', 'javascript:void(0)', array('class' => 'btn btn-default  btn-lg explorebtn form-btn', 'data-toggle' => "modal", 'data-target' => "#withdraw-modal"));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 total-expense"> 
                <?php
                
                if ($expense > 0 || $revenue > 0) {
                    $this->Widget('ext.highcharts.HighchartsWidget', array(
                        'options' => array(
                            'colors' => array('#B41B20', '#04A61B', '#04A61B'),
                            'gradient' => array('enabled' => false),
                            'credits' => array('enabled' => false),
                            'exporting' => array('enabled' => false),
                            'chart' => array(
                                'plotBackgroundColor' => '#fff',
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                                'height' => 300,
                            ),
                            'title' => false,
                            'tooltip' => array(
                                // 'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
                                // 'percentageDecimals' => 1,
//                            'formatter' => 'js:function() { return this.point.name+":  <b>"+Math.round(this.point.percentage)+"</b>%"; }',
                                'formatter' => 'js:function() { return this.point.name+":  <b>"+this.y+"</b> $"; }',
                            //the reason it didnt work before was because you need to use javascript functions to round and refrence the JSON as this.<array>.<index> ~jeffrey
                            ),
                            'plotOptions' => array(
                                'pie' => array(
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => array(
                                        'enabled' => true,
                                        'color' => '#AAAAAA',
                                        'connectorColor' => '#AAAAAA',
                                        'style' => array(
                                            'textShadow' => false
                                        ),
                                    ),
                                    'showInLegend' => true,
                                )
                            ),
                            'legend' => array(
                                'borderColor' => "#F0F0F0",
                                'borderWidth' => 2,
                            ),
                            'series' => array(
                                array(
                                    'type' => 'pie',
                                    'name' => 'Percentage',
                                    'data' => array(
                                        array('Total Expense', (float) $expense),
                                        array('Total Revenue', (float) $revenue),
                                        array('Current Balance', (float) $balance),
                                    ),
                                ),
                            ),
                        )
                    ));
                }
                ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 payment-table ">  
                <div class="table-responsive">
                    <table width="100%" border="0" class="table ">
                        <tr>
                            <th>Date </th>
                            <th>Description </th>
                            <th>Processing fees ($)</th>
                            <th>Payment ($)</th>
                        </tr>
                        <?php if (!empty($my_payments)) { ?>
                            <?php foreach ($my_payments as $my_payment) { ?>
                                <?php if ($my_payment->trans_type == Transaction::TYPE_REVENUE) { ?>
                                    <tr>
                                        <td><?php echo $my_payment->created_at ?></td>
                                        <td>
                                            <p>
                                                <?php echo CHtml::link($my_payment->booking->cam->cam_title, array('/site/cam/view', 'slug' => $my_payment->booking->cam->slug)); ?>
                                            </p>
                                            <p class="paid">
                                                User Paid : <?php echo $my_payment->booking->book_total_price ?> $ 
                                            </p>
                                            <p>(Inc. Processing & Service Tax)</p>
                                        </td>
                                        <td><?php echo $my_payment->trans_admin_amount; ?></td>
                                        <td><?php echo $my_payment->trans_user_amount; ?></td>
                                    </tr>
                                <?php } elseif ($my_payment->trans_type == Transaction::TYPE_WITHDRAW) { ?>
                                    <tr>
                                        <td><?php echo $my_payment->created_at ?></td>
                                        <td> 
                                            <p class="paid"> Paypal : <?php echo $my_payment->paypal_address; ?></p>
                                            <p class="paid"> 
                                                Cash Out 
                                                <?php if ($my_payment->status == 0) { ?>
                                                    <span class="label label-default">Processing</span>
                                                <?php } elseif ($my_payment->status == 2) { ?>
                                                    <span class="label label-danger">Rejected</span>
                                                <?php } ?>
                                            </p>
                                        </td>
                                        <td>-</td>
                                        <td><?php echo $my_payment->trans_user_amount; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>