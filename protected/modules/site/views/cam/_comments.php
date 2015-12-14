<?php
$themeUrl = $this->themeUrl;

$criteria = new CDbCriteria();
$criteria->addCondition("cam_id='$model->cam_id'");
$criteria->addCondition("status='1'");
$comments_count = CamComments::model()->count($criteria);
$pages = new CPagination($comments_count);

// results per page
$pages->pageSize = 10;
$pages->applyLimit($criteria);
$cam_comments = CamComments::model()->findAll($criteria);
?>
<h2> Comments </h2>
<?php if (!empty($cam_comments)) { ?>
    <?php foreach ($cam_comments as $key => $cam_comment) { ?>
        <div class="comments-cont">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <?php echo $cam_comment->user->profilethumb; ?>
                </div>
                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                    <p> <b> <?php echo $cam_comment->user->username ?> </b></p>
                    <p> 
                        <?php
                        $this->widget('ext.DzRaty.DzRaty', array(
                            'name' => 'com_rating' . $key,
                            'value' => $cam_comment->com_rating,
                            'options' => array(
                                'readOnly' => TRUE,
                            ),
                        ));
                        ?>
                    </p>
                    <p> <?php echo $cam_comment->com_comment ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="pagination-cont">
        <nav>
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $pages,
                "cssFile" => false,
                'header' => '',
                'htmlOptions' => array('class' => 'pagination'),
                'prevPageLabel' => '<span aria-hidden="true">«</span></a>',
                'firstPageLabel' => '<span aria-hidden="true">« First</span></a>',
                'nextPageLabel' => '<span aria-hidden="true">»</span>',
                'lastPageLabel' => '<span aria-hidden="true">Last »</span>',
                'selectedPageCssClass' => 'active',
                'selectedPageCssClass' => 'active',
                'maxButtonCount' => 5,
                'id' => 'link_pager',
            ));
            ?>
        </nav>
    </div>
<?php } else { ?>
    <h3>No Comments</h3>
<?php } ?>
