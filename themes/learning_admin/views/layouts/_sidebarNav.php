<div data-scrollable>
    <div class="sidebar-block">
        <div class="profile">
            <a href="#">
                <?php echo CHtml::image("{$this->themeUrl}/img/people/110/avatar5.png", 'Image', array('class' => 'img-circle width-80')) ?>
            </a>
            <h4 class="text-display-1 margin-none"><?php echo Yii::app()->user->name; ?></h4>
        </div>
    </div>
    <?php
    /**/
    $this->widget('zii.widgets.CMenu', array(
        'activateParents' => true,
        'encodeLabel' => false,
        'activateItems' => true,
        'activeCssClass' => 'active open',
        'items' => array(
            array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => array('/admin/default/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-users"></i> <span>Users Management</span>', 'url' => array('/admin/user/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-file-text"></i> <span>CMS Management</span>', 'url' => array('/admin/cms/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-question"></i> <span>FAQ Management</span>', 'url' => array('/admin/faq/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-cart-plus"></i> <span>Purchase Management</span>', 'url' => array('/admin/purchase/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-th-list"></i> <span>Cam Management</span>', 'url' => '#cam-menu',
                'itemOptions' => array('class' => 'hasSubmenu'),
                'submenuOptions' => array('id' => 'cam-menu'),
                'visible' => '1',
                'items' => array(
                    array('label' => '<i class="fa fa-cubes"></i> <span>Cam Category</span>', 'url' => array('/admin/camcategory/index'), 'visible' => '1'),
                    array('label' => '<i class="fa fa-wechat"></i> <span>Cam</span>', 'url' => array('/admin/cam/index'), 'visible' => '1'),
                ),
            ),
            array('label' => '<i class="fa fa-money"></i> <span>Payment Management</span>', 'url' => '#payment-menu',
                'itemOptions' => array('class' => 'hasSubmenu'),
                'submenuOptions' => array('id' => 'payment-menu'),
                'visible' => '1',
                'items' => array(
                    array('label' => '<i class="fa fa-paypal"></i> <span>Cash Withdraw</span>', 'url' => array('/admin/transaction/cashwithdraw'), 'visible' => '1'),
                ),
            ),
            array('label' => '<i class="fa fa-quote-left"></i> <span>Testimonials</span>', 'url' => array('/admin/testimonial/index'), 'visible' => '1'),
        ),
        'htmlOptions' => array('class' => 'sidebar-menu')
    ));
    ?>
</div>