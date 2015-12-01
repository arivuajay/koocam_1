<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $token GigTokens */
/* @var $form CActiveForm */

$this->title = 'Chat';
$themeUrl = $this->themeUrl;
?>
<div class="body-cont">
    <div id="inner-banner" class="tt-fullHeight3">
        <div class="container homepage-txt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details">
                </div>
            </div>
        </div>
    </div>
    <div class="innerpage-cont">
        <div class="container">
            <?php
            echo CHtml::tag('div', array('id' => 'errorDiv', 'class' => 'text-danger', 'style' => 'word-wrap: break-word;'), '');
            echo '<br />';
            echo CHtml::tag('div', array('id' => 'subscribersDiv'), '');
            echo '<br />';
            echo CHtml::tag('div', array('id' => 'myPublisherDiv'), '');
        
            $this->widget('ext.yii-opentok.EOpenTokWidget', array(
                'key' => Yii::app()->tok->key,
                'sessionId' => $token->session_key,
                'token' => $token->token_key,
            ));
            
            ?>
            <br />
            <div id="msgHistory"></div>
            <br />
            <form id="chat-form">
                <input type="text" placeholder="chat" id="msgTxt" class="form-control" /><br />
                <input type="submit" class="btn btn-small explorebtn" value="Send" />
            </form>
            <hr/>
            <a href="javascript:void(0)" id="connect" class="hide">Connect Again</a>
            <br />
            <a href="javascript:void(0)" id="disconnect">DisConnect</a>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("https://static.opentok.com/v2/js/opentok.min.js");
?>