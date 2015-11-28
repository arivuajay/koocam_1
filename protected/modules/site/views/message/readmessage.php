<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */

$this->title = 'Messages - Conversation';
$this->breadcrumbs = array(
    'Messages - Conversation',
);

$session_userid = Yii::app()->user->id;

if ($u1 != $session_userid) {
    $userto_id = $u1;
}
if ($u2 != $session_userid) {
    $userto_id = $u2;
}

?>
<div id="inner-banner" class="tt-fullHeight3">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                <h2> Messages - Conversation </h2>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                <div class="nano">
                    <div class="table-responsive nano-content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                            <tr>          
                                <th class="author">User</th>
                                <th>Message</th>
                                <th>Sent</th>
                            </tr>
                            <?php
                            foreach ($mymessages as $minfos) {
                                ?>
                                <tr>
                                    <td><?php echo $minfos['username']; ?></td>
                                    <td><?php echo $minfos['message']; ?></td>
                                    <td><?php echo date('m/d/Y H:i:s', $minfos['timestamp']); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>     
            </div>    
        </div>

        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
                <div class="inner-container"> 
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8"><h2>Reply</h2></div>  
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'message-form',
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    ));
//echo $form->errorSummary(array($model));
                    ?>
                    <div class="forms-cont"> 
                        <div class="row"> 

                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                    <?php echo $form->labelEx($model, 'message'); ?>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">       
                                    <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>  
                                    <?php echo $form->error($model, 'message'); ?>
                                </div> 
                            </div>

                            <?php echo $form->hiddenField($model, 'user2', array("value" => $userto_id)); ?>
                            <?php echo $form->hiddenField($model, 'id2', array("value" => count($mymessages) + 1)); ?>

                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                                    <?php
                                    echo CHtml::tag('button', array(
                                        'name' => 'btnSubmit',
                                        'type' => 'submit',
                                        'class' => 'submit-btn'
                                            ), '<i class="fa fa-check-circle"></i> Submit');
                                    ?>
                                </div>
                            </div>  

                        </div>  
                    </div>    
                    <?php $this->endWidget(); ?>
                </div>
            </div> 
        </div>  
    </div>
</div>