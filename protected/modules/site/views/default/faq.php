<?php 
$themeUrl = $this->themeUrl;
$this->title = 'FAQ';
?>
<div id="inner-banner" class="tt-fullHeight3 faq-banner">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">
                <h2><?php echo CHtml::link('Frequently asked questions ', array('/site/default/faq')); ?></h2>
                <!-- <a href="#"> FAQS</a>--><br/>
            </div>
        </div>
    </div>
</div>
<div class="innerpage-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-details">
                <div class="panel-group" id="accordion">
                    <?php foreach ($faqs as $key => $faq): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $key; ?>">
                                    <span>  <?php echo $key+1; ?> </span><?php echo $faq->question; ?> 
                                </a>
                            </h4>
                        </div>
                        <div id="<?php echo $key; ?>" class="panel-collapse collapse <?php echo $key == 0 ? 'in' : ''; ?>">
                            <div class="panel-body">
                                <?php echo $faq->answer; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
