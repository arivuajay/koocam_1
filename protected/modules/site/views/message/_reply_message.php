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