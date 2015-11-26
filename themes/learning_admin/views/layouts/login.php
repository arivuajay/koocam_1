<!DOCTYPE html>
<html class="hide-sidebar ls-bottom-footer" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo CHtml::encode($this->title); ?></title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($themeUrl . '/css/vendor/all.css');
        $cs->registerCssFile($themeUrl . '/css/app/app.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>
    </head>
    <body class="login">
        <?php echo $content ?>
        <!-- Footer -->
        <footer class="footer">
                <strong><?php echo Yii::app()->name ?></strong> &copy; Copyright <?php echo date('Y'); ?>
        </footer>
        <script>
            var colors = {
                "danger-color": "#e74c3c",
                "success-color": "#81b53e",
                "warning-color": "#f0ad4e",
                "inverse-color": "#2c3e50",
                "info-color": "#2d7cb5",
                "default-color": "#6e7882",
                "default-light-color": "#cfd9db",
                "purple-color": "#9D8AC7",
                "mustard-color": "#d4d171",
                "lightred-color": "#e15258",
                "body-bg": "#f6f6f6"
            };
            var config = {
                theme: "html",
                skins: {
                    "default": {
                        "primary-color": "#42a5f5"
                    }
                }
            };
        </script>

        <?php
        $cs_pos_end = CClientScript::POS_END;

        $cs->registerCoreScript('jquery');
//        $cs->registerScriptFile($themeUrl . '/js/vendor/all.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/bootstrap.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/breakpoints.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/jquery.nicescroll.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/isotope.pkgd.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/packery-mode.pkgd.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/jquery.grid-a-licious.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/jquery.cookie.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/jquery-ui.custom.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/jquery.hotkeys.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/handlebars.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/load_image.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/jquery.debouncedresize.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/modernizr.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/core/velocity.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/tables/all.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/forms/all.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/media/slick.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/charts/flot/all.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/nestable/jquery.nestable.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/countdown/all.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor/angular/all.js', $cs_pos_end);
        
        $cs->registerScriptFile($themeUrl . '/js/app/app.js', $cs_pos_end);
        ?>
    </body>
</html>