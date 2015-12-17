<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $token CamTokens */
/* @var $form CActiveForm */
$this->title = 'Success';
$themeUrl = $this->themeUrl;

?>
<div id="inner-banner" class="tt-fullHeight3 chat-banner">
    <div class="container homepage-txt">
        <div class="row">
            Success
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row" id="after_chat">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-12 text-center">
                <p>Your cam is sent for approval. Please wait !!!</p>
                <br />
                <div>
                    <?php echo CHtml::link('Go to Home', array('/site/default/index'), array('class' => 'btb btn-lg btn-success')); ?>
                </div>
            </div>
            
        </div>
        <br />
    </div>
</div>
