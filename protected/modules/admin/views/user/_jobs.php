
                    <?php
                    $gridColumns = array(
                        array(
                            'class' => 'IndexColumn',
                            'header' => '',
                        ),
                        'bookUser.username',
                        'cam.cam_title',
                        array(
                            'name' => 'book_date',
                            'value' => function($data) {
                                echo date(PHP_SHORT_DATE_FORMAT, strtotime($data->book_date));
                        }),
                        array(
                            'name' => 'book_start_time',
                            'value' => function($data) {
                                echo date('H:i', strtotime($data->book_start_time));
                        }),
                        array(
                            'name' => 'book_end_time',
                            'value' => function($data) {
                                echo date('H:i', strtotime($data->book_end_time));
                        }),
                        'book_duration',
                        'book_session',
                        'book_total_price',
                        array(
                            'name' => 'book_is_extra',
                            'value' => function($data) {
                                echo $data->book_is_extra == 'Y' ? '<i class="fa fa-circle text-green-500"></i>' : '<i class="fa fa-circle text-red-500"></i>';
                        }),
//                          'book_cam_price',
//                          'book_extra_price',
//                          'book_message',
//                          'book_approve',
//                          'book_approved_time',
//                          'book_declined_time',
//                          'book_payment_status',
//                          'book_payment_info',
//                          'book_duration',
//                          'created_at',
                    );

                    $this->widget('application.components.MyExtendedGridView', array(
                        'filter' => $job_model,
                        'type' => 'striped bordered',
                        'dataProvider' => $job_model->search(),
                        'responsiveTable' => true,
                        "itemsCssClass" => "table v-middle",
                        'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>
                