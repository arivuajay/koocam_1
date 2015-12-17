
                    <?php
                    $gridColumns = array(
                        array(
                            'class' => 'IndexColumn',
                            'header' => '',
                        ),
                        'cam_title',
                        array(
                            'name' => 'cat.cat_name',
                            'filter' => CHtml::activeTextField($cam_model, 'camCategory', array('class' => 'form-control')),
                            'value' => '$data->cat->cat_name'
                        ),
                        'cam_duration',
                        'cam_price',
                        array(
                            'name' => 'created_at',
                            'filter' => false
                        ),
                    );

                    $this->widget('application.components.MyExtendedGridView', array(
                        'filter' => $cam_model,
                        'type' => 'striped bordered',
                        'dataProvider' => $cam_model->search(),
                        'responsiveTable' => true,
                        "itemsCssClass" => "table v-middle",
                        'template' => '<div class="panel panel-default"><div class="table-responsive">{items}{pager}</div></div>',
                        'columns' => $gridColumns
                            )
                    );
                    ?>
                