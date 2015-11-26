<?php $this->beginContent('//layouts/main'); ?>
<?php
//$this->widget('zii.widgets.CBreadcrumbs', array(
//    'links' => $this->breadcrumbs,
//    'tagName' => 'ul', // container tag
//    'htmlOptions' => array('class' => 'breadcrumb'), // no attributes on container
//    'separator' => '', // no separator
//    'homeLink' => '<li><a href="' . Yii::app()->baseUrl . '/admin/default/index"><i class="fa fa-home"></i> Home</a></li>', // home link template
//    'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // active link template
//    'inactiveLinkTemplate' => '<li class="active">{label}</li>', // in-active link template
//));
?>
<?php if (isset($this->flashMessages) && !empty($this->flashMessages)):
    $key = key($this->flashMessages);
    $message = $this->flashMessages[$key];
    $js = <<< EOD
    jQuery(document).ready(function ($) {
        $.smkAlert({text:'{$message}', type:'{$key}', time: 25});
    });

EOD;

    Yii::app()->clientScript->registerScript('column1', $js);
endif
?>

<?php echo $content; ?>
<?php $this->endContent(); ?>