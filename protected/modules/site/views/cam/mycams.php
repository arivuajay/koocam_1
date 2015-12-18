<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $results Cam[] */
/* @var $cam Cam */
/* @var $form CActiveForm */

$this->title = 'My Cams';
$this->breadcrumbs = array(
    'Cams',
);
$themeUrl = $this->themeUrl;
?>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
    <div class="myprofile-inner">
        <div class="row">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $key => $cam): ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="courses-thumb-cont">
                            <div class="course-thumbimg">
                                <div class="cam-delete" >
                                    <?php echo CHtml::link('<i class="fa fa-trash"></i>', array('/site/cam/userdelete', 'id' => $cam->cam_id), array('onclick' => 'return confirm("Are you sure to delete ?")')); ?>
                                </div>
                                <?php
                                $image = $cam->camthumb;
                                echo CHtml::link($image, array('/site/cam/view', 'slug' => $cam->slug));
                                ?>
                            </div>
                            <div class="course-thumbdetails">
                                <h2><?php echo CHtml::link($cam->cam_title, array('/site/cam/view', 'slug' => $cam->slug)); ?></h2>
                                <p> <span> <?php echo CHtml::link($cam->tutor->fullname, array('/site/user/profile', 'slug' => $cam->tutor->slug)); ?> </span> </p>
                                <?php
                                $this->widget('ext.DzRaty.DzRaty', array(
                                    'name' => 'cam_rating_mycams' . $key,
                                    'value' => $cam->cam_rating,
                                    'options' => array(
                                        'readOnly' => TRUE,
                                        'half' => TRUE,
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'new-half-class hide'
                                    ),
                                ));
                                ?>
                            </div>
                            <div class="coures-pricedetails">
                                <div class="course-price"> <i class="fa fa-clock-o"></i> <b><?php echo $cam->cam_duration; ?></b> <span> min </span> </div>
                                <div class="course-price course-hour"> <i class="fa fa-dollar"></i> <b><?php echo (float) $cam->cam_price; ?></b> </div>
                                <div class="course-price letcame">   <?php echo CHtml::link('<i class="fa fa-pencil"></i>  Edit', array('/site/cam/update', 'id' => $cam->cam_id)); ?> </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h4 class="text-center">No Cams Found</h4>
            <?php endif; ?>
        </div>

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
    </div>
</div>

