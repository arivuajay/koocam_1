<div class='hide' id='details<?php echo $com_id; ?>'>
    <div class='form-group'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            Comment : <?php echo $comment ?>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            Rating : <?php
            $this->widget('ext.DzRaty.DzRaty', array(
                'name' => 'cam_rating_' . $com_id,
                'value' => $rating,
                'options' => array(
                    'readOnly' => TRUE,
                ),
            ));
            ?> 
        </div>
    </div>
</div>