<?php
/* @var $this Controller */
?>
<div class="clearfix"></div>
<div class="footer-cont">
    <div class="container">
        <div class="footer-row1">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul>
                        <li><?php echo CHtml::link(' About Us ', array('/site/cms/view', 'slug' => 'about-us')); ?></li>
                        <li><?php echo CHtml::link(' How it Works ', array('/site/cms/view', 'slug' => 'howitworks')); ?></li>
                        <li><?php echo CHtml::link(' Contact Us ', array('/site/default/contactus')); ?></li>
                        <li><?php echo CHtml::link(' Terms and Conditions ', array('/site/cms/view', 'slug' => 'terms-and-conditions')); ?></li>
                        <li><?php echo CHtml::link(' Privacy Policy ', array('/site/cms/view', 'slug' => 'privacy-policy')); ?></li>
                        <li><?php echo CHtml::link(' FAQ ', array('/site/default/faq')); ?></li>
                    </ul>
                    <p> Copyrights © <?php echo date("Y"); ?>. Koocam.com. Allrights reserved </p>
                </div>
            </div>
        </div>
        <div class="footer-row2">
<!--            <p> 
                <span> Address : Dummystreet,city-123456 </span> 
                <span> Phone : (123) 456-7890 </span> 
                <span> Email : <?php echo CHtml::link('support@koocam.com', 'mailto:support@koocam.com'); ?></span> 
            </p>-->
            <p> 
                <?php echo CHtml::link(CHtml::image($this->themeUrl.'/images/fb.png', ''), 'https://www.facebook.com/Koocam-1656996354590122/?ref=bookmarks', array('target' => '_blank')); ?>
                
                <?php echo CHtml::link(CHtml::image($this->themeUrl.'/images/twitter.png', ''), 'https://twitter.com/koocamcom', array('target' => '_blank')); ?>
                
                <?php echo CHtml::link(CHtml::image($this->themeUrl.'/images/gplus.png', '', array('width' => '32', 'height' => '32')), 'https://plus.google.com/u/0/101063596958477156773/about', array('target' => '_blank')); ?>
                
                <?php echo CHtml::link(CHtml::image($this->themeUrl.'/images/youtube.png', '', array('width' => '32', 'height' => '32')), 'https://www.youtube.com/channel/UCP4-gX_bC2gmAQBDF0z87Pw/feed', array('target' => '_blank')); ?>
            </p>
        </div>
    </div>
</div>