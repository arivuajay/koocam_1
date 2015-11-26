<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$this->title = 'Chat';
$this->breadcrumbs = array(
    'Gig' => array('/site/gig'),
    'Create',
);
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
//            $expire = time()+(7 * 24 * 60 * 60);
//            $role = 'publisher';
//            echo $sessionId = Yii::app()->tok->createSession()->id;
//            echo '<br />';
//            echo Yii::app()->tok->generateToken($sessionId, $role, $expire);
//            exit;

            echo CHtml::tag('div', array('id' => 'errorDiv', 'class' => 'text-danger', 'style' => 'word-wrap: break-word;'), '');
            echo '<br />';
            echo CHtml::tag('div', array('id' => 'subscribersDiv'), '');
            echo '<br />';
            echo CHtml::tag('div', array('id' => 'myPublisherDiv'), '');
        
            $this->widget('ext.yii-opentok.EOpenTokWidget', array(
                'key' => Yii::app()->tok->key,
                'sessionId' => '2_MX40NTM5ODE1Mn5-MTQ0ODAwNTIzNDcwMX4wK0t1NSs4emNRR1pYdW5ZOVNLWG5wUXR-UH4',
                'token' => 'T1==cGFydG5lcl9pZD00NTM5ODE1MiZzaWc9ZjgxYjU4ZWE1OWMzOTVkMDhhMmM3OTA3NDY2MzlmYzk4ZjE2YmQwZDpyb2xlPW1vZGVyYXRvciZzZXNzaW9uX2lkPTJfTVg0ME5UTTVPREUxTW41LU1UUTBPREF3TlRJek5EY3dNWDR3SzB0MU5TczRlbU5SUjFwWWRXNVpPVk5MV0c1d1VYUi1VSDQmY3JlYXRlX3RpbWU9MTQ0ODAwNTUxMSZub25jZT0wLjkyNTg4NTgzMTIxODQ1NDImZXhwaXJlX3RpbWU9MTQ0ODAyNjgyOCZjb25uZWN0aW9uX2RhdGE9',
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