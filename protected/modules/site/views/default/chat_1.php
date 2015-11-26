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
//            $ip = CHttpRequest::getUserHostAddress();
//            $expire = time()+(7 * 24 * 60 * 60);
//            $role = 'moderator';
//            echo $sessionId = Yii::app()->tok->createSession()->id;
//            echo '<br />';
//            echo Yii::app()->tok->generateToken($sessionId, $role, $expire);
//            exit;

            $this->widget('ext.yii-opentok.EOpenTokWidget', array(
                'key' => Yii::app()->tok->key,
                'sessionId' => '2_MX40NTM5ODE1Mn5-MTQ0ODAxNjE1ODA0OX5OaVdpMWtGbjZXeUxqK2JyMElldmVVSnV-fg',
                'token' => 'T1==cGFydG5lcl9pZD00NTM5ODE1MiZzaWc9ZjQyMGU5YTBlY2ZkNzJkYmUyZTExM2IyMjE0MTg2ZmExYzVhNjBlYTpzZXNzaW9uX2lkPTJfTVg0ME5UTTVPREUxTW41LU1UUTBPREF4TmpFMU9EQTBPWDVPYVZkcE1XdEdialpYZVV4cUsySnlNRWxsZG1WVlNuVi1mZyZjcmVhdGVfdGltZT0xNDQ4MDE2MTU2JnJvbGU9bW9kZXJhdG9yJm5vbmNlPTE0NDgwMTYxNTYuNDc5MTE0NzM1MjAmZXhwaXJlX3RpbWU9MTQ0ODYyMDk1NiZjb25uZWN0aW9uX2RhdGElNUJzZXNzaW9uX2lkJTVEPTJfTVg0ME5UTTVPREUxTW41LU1UUTBPREF4TmpFMU9EQTBPWDVPYVZkcE1XdEdialpYZVV4cUsySnlNRWxsZG1WVlNuVi1mZyZjb25uZWN0aW9uX2RhdGElNUJjcmVhdGVfdGltZSU1RD0xNDQ4MDE2MTU2JmNvbm5lY3Rpb25fZGF0YSU1QnJvbGUlNUQ9bW9kZXJhdG9yJmNvbm5lY3Rpb25fZGF0YSU1Qm5vbmNlJTVEPTE0NDgwMTYxNTYuNDc5MTE0NzM1MjAmY29ubmVjdGlvbl9kYXRhJTVCZXhwaXJlX3RpbWUlNUQ9MTQ0ODYyMDk1Ng==',
            ));
            ?>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("https://static.opentok.com/v2/js/opentok.min.js");

$js = <<< EOD
    jQuery(document).ready(function ($) {
    });

EOD;

Yii::app()->clientScript->registerScript('chat', $js);
?>