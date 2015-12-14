<?php
/* @var $this DefaultController */

$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);
$result = Myclass::dashBoardResults(); ?>

<div class="container-fluid">
    <!--    <div class="page-section">
            <h1 class="text-display-1 margin-none">Dashboard</h1>
        </div>-->
    <div class="row">
        <div class="item col-xs-12 col-lg-6">
            <div class="panel panel-default paper-shadow" data-z="0.5">
                <div class="panel-heading">
                    <h4 class="text-headline margin-none">Site Details</h4>
                    <p class="text-subhead text-light">recent performance</p>
                </div>
                <ul class="list-group">
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Numbers of new users today
                            </h4>
                            <!--                            <div class="caption">
                                                            <span class="text-light">Course:</span>
                                                            <a href="app-take-course.html">Basics of HTML</a>
                                                        </div>-->
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-cyan-300"><?php echo $result['new_users_per_day']; ?></div>
                            <!--<span class="caption text-light">Good</span>-->
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Numbers of total users in the system
                            </h4>
                            <!--                            <div class="caption">
                                                            <span class="text-light">Course:</span>
                                                            <a href="app-take-course.html">Angular in Steps</a>
                                                        </div>-->
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-green-300"><?php echo $result['tot_users']; ?></div>
                            <!--<span class="caption text-light">Great</span>-->
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Numbers of new cams today
                            </h4>
                            <!--                            <div class="caption">
                                                            <span class="text-light">Course:</span>
                                                            <a href="app-take-course.html">Basics of HTML</a>
                                                        </div>-->
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-deep-orange-300"><?php echo $result['new_cams_per_day']; ?></div>
                            <!--<span class="caption text-light">Good</span>-->
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Most cam sold
                            </h4>
                            <div class="caption">
                                <span class="text-light">Cam Title:</span>
                                <?php echo CHtml::link($result['most_cam'], array('/admin/cam/view', 'id' => $result['most_cam_id'])); ?>
                            </div>
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-red-300"><?php echo $result['most_cam_count']; ?></div>
                            <!--<span class="caption text-light">Failed</span>-->
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Numbers of deleted cams today
                            </h4>
                            <!--                            <div class="caption">
                                                            <span class="text-light">Course:</span>
                                                            <a href="app-take-course.html">Angular in Steps</a>
                                                        </div>-->
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-indigo-300"><?php echo $result['deleted_cams_per_day']; ?></div>
                            <!--<span class="caption text-light">Great</span>-->
                        </div>
                    </li>
                </ul>
                <!--                <div class="panel-footer">
                                    <a href="app-student-quizzes.html" class="btn btn-primary paper-shadow relative" data-z="0" data-hover-z="1" data-animated href="#"> Go to Results</a>
                                </div>-->
            </div>
        </div>
        <div class="item col-xs-12 col-lg-6">

            <div class="panel panel-default paper-shadow" data-z="0.5">
                <div class="panel-heading">
                    <h4 class="text-headline margin-none">Financial Information</h4>
                    <p class="text-subhead text-light">recent performance</p>
                </div>
                <ul class="list-group">
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Number Cams sold today
                            </h4>
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-amber-900"><?php echo $result['cams_sold_per_day']; ?></div>
                            <!--<span class="caption text-light">Failed</span>-->
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Total Profits
                            </h4>
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-blue-300">$<?php echo $result['total_earnings']; ?></div>
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Total Service Tax
                            </h4>
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-purple-300">$<?php echo $result['total_service']; ?></div>
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Profits Today
                            </h4>
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-brown-300">$<?php echo $result['total_earning_per_day']; ?></div>
                        </div>
                    </li>
                    <li class="list-group-item media v-middle">
                        <div class="media-body">
                            <h4 class="text-subhead margin-none">
                                Service Tax Today
                            </h4>
                        </div>
                        <div class="media-right text-center">
                            <div class="text-display-1 text-amber-500">$<?php echo $result['total_service_per_day']; ?></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="item col-xs-12 col-lg-6">
            <div class="panel panel-default paper-shadow" data-z="0.5">
                <div class="panel-heading">
                    <div class="media v-middle">
                        <div class="media-body">
                            <h4 class="text-headline margin-none">Cams in Categories</h4>
                            <p class="text-subhead text-light">Number of cams in each category</p>
                        </div>
                        <!--                        <div class="media-right">
                                                    <a class="btn btn-white btn-flat" href="website-instructor-statement.html">Statement</a>
                                                </div>-->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-subhead v-middle">
                        <tbody>
                            <?php foreach ($result['cam_categories'] as $cam_category): ?>
                                <tr>
                                    <td><?php echo $cam_category->cat_name; ?></td>
                                    <td class="width-80 text-center">&nbsp;</td>
                                    <td class="width-50 text-center"><?php echo count($cam_category->cams); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
        <div class="item col-xs-12 col-lg-6">
            <div class="panel panel-default paper-shadow" data-z="0.5">
                <div class="panel-heading">
                    <div class="media v-middle">
                        <div class="media-body">
                            <h4 class="text-headline margin-none">User Country Statistics</h4>
                            <p class="text-subhead text-light">Number of users in each country</p>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <?php
                    $data = array();
                    foreach ($result['user_country'] as $country => $count) {
                        $data[] = array($country, (float) $count);
                    }
                    $this->Widget('booster.widgets.TbHighCharts', array(
                        'options' => array(
//                            'colors' => array('#B41B20', '#04A61B', '#04A61B'),
                            'gradient' => array('enabled' => false),
                            'credits' => array('enabled' => false),
                            'exporting' => array('enabled' => false),
                            'chart' => array(
                                'plotBackgroundColor' => '#fff',
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                                'height' => 300,
                            ),
                            'title' => false,
                            'tooltip' => array(
                                // 'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
                                // 'percentageDecimals' => 1,
//                            'formatter' => 'js:function() { return this.point.name+":  <b>"+Math.round(this.point.percentage)+"</b>%"; }',
                                'formatter' => 'js:function() { return this.point.name+":  <b>"+this.y+"</b>"; }',
                            //the reason it didnt work before was because you need to use javascript functions to round and refrence the JSON as this.<array>.<index> ~jeffrey
                            ),
                            'plotOptions' => array(
                                'pie' => array(
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => array(
                                        'enabled' => true,
                                        'color' => '#AAAAAA',
                                        'connectorColor' => '#AAAAAA',
                                        'style' => array(
                                            'textShadow' => false
                                        ),
                                    ),
                                    'showInLegend' => true,
                                )
                            ),
                            'legend' => array(
                                'borderColor' => "#F0F0F0",
                                'borderWidth' => 2,
                            ),
                            'series' => array(
                                array(
                                    'type' => 'pie',
                                    'name' => 'Percentage',
                                    'data' => $data,
                                ),
                            ),
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

