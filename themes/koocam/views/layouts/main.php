<!DOCTYPE html>
<html class="st-layout ls-top-navbar-large ls-bottom-footer show-sidebar sidebar-l3" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:image" content='<?php echo $this->ogimage; ?>' />
        <meta property="og:url" content='<?php echo $this->ogurl; ?>' />
        <?php // if (!empty($this->ogvideo)) { ?>
            <!--<meta property="og:video:url" content='<?php echo $this->ogvideo; ?>' />--> 
            <!--        <meta property="og:video:width" content="560" />  
                    <meta property="og:video:height" content="340" />  -->
            <!--<meta property="og:video:type" content="application/x-shockwave-flash" />-->
        <?php // } ?>
        <title> <?php echo $this->title ?> </title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($themeUrl . '/css/bootstrap.min.css');
        $cs->registerCssFile($themeUrl . '/css/style.css');
        $cs->registerCssFile($themeUrl . '/css/responisve.css');
        $cs->registerCssFile($themeUrl . '/css/font-awesome.css');
        $cs->registerCssFile($themeUrl . '/css/owl.carousel.css');
        $cs->registerCssFile($themeUrl . '/css/bootstrap-select.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        $cs->registerCssFile($themeUrl . '/css/notification/smoke.min.css');
        $cs->registerCssFile($themeUrl . '/css/dropdowns-enhancement.css');
        ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-73142306-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <?php $this->renderPartial('//layouts/_headerBar'); ?>
        <div class="body-cont">
            <?php echo $content; ?>
        </div>
        <?php $this->renderPartial('//layouts/_footer'); ?>
        <?php
        $loginModel = new LoginForm;
        $userModel = new User;
        $forgotModel = new LoginForm("forgotpass");
        $this->renderPartial('//layouts/_login', array('model' => $loginModel));
        $this->renderPartial('//layouts/_signup', array('model' => $userModel));
        $this->renderPartial('//layouts/_forgot_password', array('model' => $forgotModel));
        ?>

        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerCoreScript('jquery');
//        $cs->registerScriptFile($themeUrl . '/js/jquery.1.11.3.min.js', $cs_pos_end);
//        Because of Yiibooster extension called in SiteModule.php, Hide the below bootstrap.min.js
        $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js');
        $cs->registerScriptFile($themeUrl . '/js/waypoints.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.counterup.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/owl.carousel.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-select.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/notification/smoke.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/icheck.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.lionbars.0.3.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.titlealert.min.js', $cs_pos_end);

        $login = Yii::app()->createAbsoluteUrl('/site/default/signupsocial');

        $js = <<< EOD
            $('.modal').on('hidden.bs.modal', function (e) {
                $("body").removeClass("modal-open");
            });

            $('.modal').on('shown.bs.modal', function (e) {
                $("body").addClass("modal-open");
            });
                
            $('.oAuthLogin').click(function(e) {
                var _frameUrl = "$login?provider=" + $(this).data('provider');
                window.open(_frameUrl, "SignIn", "width=580,height=480,toolbar=0,scrollbars=1,status=0,resizable=0,location=0,menuBar=0,left=400,top=150");
                e.preventDefault();
                return false;
            });

            $('#login-button').on('click', function(){
                $('.bs-example-modal-sm').modal('toggle');
            });

            $('#signup-button').on('click', function(){
                $('.bs-example-modal-sm1').modal('toggle');
            });

            $('#forgot-button').on('click', function(){
                $('.bs-example-modal-sm1').modal('toggle');
            });

            $('#forgot-login-button').on('click', function(){
                $('.bs-example-modal-fg2').modal('toggle');
            });
                
            jQuery(document).ready(function ($) {
                $('.raty-icons').addClass('hide');
                
                $('input:checkbox:not(.simple),input:radio').iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });
                
                $('[data-toggle="tooltip"]').tooltip({
                    show: {
                      effect: "slideDown",
                      delay: 250
                    }
                });
                
                $("input, textarea").not(".allow_foriegn").keypress(function() {
                    onlyEnglish($(this));
                }).focusout(function() {
                    onlyEnglish($(this));
                });

            });
                
            function onlyEnglish(_this){
                var patt = /[^\u0000-\u007F ]+/;
                var value = _this.val();
                var patt_value = value.replace(patt,'');
                if (patt_value != value)
                {
                    alert("only english please.");
                    _this.val('');
                }
            }
                
            $(window).load(function(){
                $('[data-toggle="popover"]').popover();
                $('.raty-icons').removeClass('hide');
            });
                
            $('.selectpicker').selectpicker({
                dropupAuto: false,
            });

EOD;

        $this->renderPartial('//layouts/_ajaxrun');
        Yii::app()->clientScript->registerScript('inline', $js);
        ?>
    </body>
</html>