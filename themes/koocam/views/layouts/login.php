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

        $cs->registerCssFile($themeUrl . '/css/theme-core.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-essentials.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-material.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-layout.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-sidebar.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-sidebar-skins.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-navbar.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-messages.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-carousel-slick.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-charts.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-maps.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-colors-alerts.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-colors-background.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-colors-buttons.min.css');
        $cs->registerCssFile($themeUrl . '/css/module-colors-text.min.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>
    </head>
    <body class="login">
        <?php echo $content ?>
        <!-- Footer -->
        <footer class="footer">
            <strong>Learning</strong> v1.0.0 &copy; Copyright 2015
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

        $js = <<< EOD
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
EOD;
//        Yii::app()->clientScript->registerScript('_custom_js', $js);
        $cs->registerScriptFile($themeUrl . '/js/vendor-core.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-countdown.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-tables.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-forms.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-carousel-slick.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-player.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-charts-flot.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/vendor-nestable.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-essentials.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-material.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-layout.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-sidebar.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-carousel-slick.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-player.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-messages.min.js', $cs_pos_end);
//        $cs->registerScriptFile($themeUrl . '/js/module-maps-google.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/module-charts-flot.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/theme-core.min.js', $cs_pos_end);
        ?>
    </body>
</html>