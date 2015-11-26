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
    $this->widget('zii.widgets.CMenu', array(
        'activateParents' => true,
        'encodeLabel' => false,
        'activateItems' => true,
        'activeCssClass' => 'active open',
        'items' => array(
            array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => array('/admin/default/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-users"></i> <span>Users Management</span>', 'url' => array('/admin/user/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-file-text"></i> <span>CMS Management</span>', 'url' => array('/admin/cms/index'), 'visible' => '1'),
            array('label' => '<i class="fa fa-th-list"></i> <span>Gig Management</span>', 'url' => '#gig-menu',
                'itemOptions' => array('class' => 'hasSubmenu'),
                'submenuOptions' => array('id' => 'gig-menu'),
                'visible' => '1',
                'items' => array(
                    array('label' => '<i class="fa fa-cubes"></i> <span>Gig Category</span>', 'url' => array('/admin/gigcategory/index'), 'visible' => '1'),
                    array('label' => '<i class="fa fa-wechat"></i> <span>Gig</span>', 'url' => array('/admin/gig/index'), 'visible' => '1'),
                ),
            ),
        ),
        'htmlOptions' => array('class' => 'sidebar-menu')
    ));
    ?>
</div>