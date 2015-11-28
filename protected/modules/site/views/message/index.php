<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */

$this->title = 'Messages';
$this->breadcrumbs = array(
    'Messages',
);
?>
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Messages </h2>
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
                            <th width="9%">S. No</th>
                            <th width="20%"> User</th>
                            <th width="18%"> Message </th>
                            <th width="18%"> Date </th>
                        </tr>
                        <?php if (empty($model)) { ?>
                            <tr>
                                <td colspan="3"> No Records Found </td>
                            </tr>
                            <?php
                        } else {
                            $i = 1;
                            foreach ($model as $messages) {
                                $mdisplay = (strlen($messages['message']) > 20) ? substr($messages['message'], 0, 20) . '...' : $messages['message'];
                                ?>  
                                <tr>
                                    <td width="9%">
                                        <?php echo $i; ?>
                                    </td>
                                    <td width="20%">
                                        <?php echo $messages['username']; ?>
                                    </td>
                                    <td width="18%">
                                        <?php echo CHtml::link($mdisplay, array('/site/message/readmessage', 'conversation_id' => $messages['id1'])); ?>
                                    </td>
                                    <td width="18%">
                                        <?php echo date(PHP_SHORT_DATE_TIME_FORMAT, strtotime($messages['created_at'])); ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </table>
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
    </div>
</div>