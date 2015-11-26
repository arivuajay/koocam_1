<?php $this->beginContent('//layouts/main'); ?>

<!-- sidebar effects INSIDE of st-pusher: -->
<!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->
<!-- this is the wrapper for the content -->

<div class="st-content">
    <div class="st-content-inner padding-none">

        <?php if (isset($this->flashMessages)): ?>
            <?php foreach ($this->flashMessages as $key => $message) { ?>
                <div class="alert alert-<?php echo $key; ?> fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $message; ?>
                </div>
            <?php } ?>
        <?php endif ?>

        <div class="container-fluid" id="admin-headerbar">
            <div class="page-section">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links' => $this->breadcrumbs,
                            'tagName' => 'ul', // container tag
                            'htmlOptions' => array('class' => 'breadcrumb'), // no attributes on container
                            'separator' => '', // no separator
                            'homeLink' => '<li><a href="' . Yii::app()->baseUrl . '/admin/default/index"><i class="fa fa-home"></i> Home</a></li>',
                            'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // active link template
                            'inactiveLinkTemplate' => '<li class="active">{label}</li>', // in-active link template
                        ));
                        ?>
                    </div>
                    <div class="col-lg-4">
                        <?php echo $this->rightCornerLink;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $content; ?>
    </div>
</div>
<!-- /st-content-inner -->
<!-- /st-content -->
<?php $this->endContent(); ?>