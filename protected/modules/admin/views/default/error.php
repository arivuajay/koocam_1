<?php
$this->title = $name;
?>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"> <?php echo $error['code']; ?></h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! <?php echo $message; ?>.</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href='<?php echo Yii::app()->createAbsoluteUrl('site/default/index') ?>'>return to dashboard</a> or try using the search form.
            </p>

        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

</section><!-- /.content -->
